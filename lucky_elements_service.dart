import 'dart:math';
import 'package:bluebyte_flutter_getx/app/data/models/user_model.dart';
import 'package:bluebyte_flutter_getx/app/modules/detail/services/constants/time_constants.dart';
import 'package:bluebyte_flutter_getx/app/modules/detail/services/lunar_service.dart';
import 'package:bluebyte_flutter_getx/app/utils/logger_utils.dart';
import 'package:flutter/material.dart';

/// Extension cung cấp các phương thức tính toán màu hợp và con số may mắn
/// tích hợp với các dịch vụ hiện có
extension LuckyElementsExtension on LunarService {
  /// Các hằng số và dữ liệu tĩnh

   static const Map<String, List<Map<String, dynamic>>> hanhToColors = {
    'kim': [
      {'name': 'Trắng', 'color': Color(0xFFFFFFFF), 'hex': '#FFFFFF'}, // Giữ nguyên Trắng tinh
      {'name': 'Xám Tro', 'color': Color(0xFFA0A0A0), 'hex': '#A0A0A0'}, // Đổi Bạc thành Xám Tro (Ash Gray) - tối hơn rõ rệt so với trắng và khác biệt với vàng kim
      {'name': 'Vàng Kim', 'color': Color(0xFFFFD700), 'hex': '#FFD700'}, // Giữ nguyên Vàng Kim
    ],
    'mộc': [
      {'name': 'Xanh Lá Cây', 'color': Color(0xFF228B22), 'hex': '#228B22'}, // ForestGreen - một màu xanh lá đậm, rõ ràng
      {'name': 'Xanh Lục Nhạt', 'color': Color(0xFF90EE90), 'hex': '#90EE90'}, // LightGreen - màu xanh lá cây rất sáng, khác biệt rõ
      {'name': 'Xanh Ngọc Bích', 'color': Color(0xFF00A99D), 'hex': '#00A99D'}, // Giữ nguyên Xanh Ngọc, đổi tên để rõ hơn
    ],
    'thủy': [
      {'name': 'Đen', 'color': Color(0xFF000000), 'hex': '#000000'},
      {'name': 'Xanh Lam Đậm', 'color': Color(0xFF00008B), 'hex': '#00008B'}, // DarkBlue - khác với Xanh Nước Biển
      {'name': 'Xanh Nước Biển', 'color': Color(0xFF1E90FF), 'hex': '#1E90FF'}, // DodgerBlue - một màu xanh nước biển sáng và phổ biến
    ],
    'hỏa': [
      {'name': 'Đỏ Tươi', 'color': Color(0xFFFF0000), 'hex': '#FF0000'}, // Giữ nguyên Đỏ
      {'name': 'Hồng Cánh Sen', 'color': Color(0xFFFF69B4), 'hex': '#FF69B4'}, // HotPink - một màu hồng rõ ràng
      {'name': 'Tím Đậm', 'color': Color(0xFF800080), 'hex': '#800080'}, // Purple - một màu tím cổ điển
    ],
    'thổ': [
      {'name': 'Vàng Nghệ', 'color': Color(0xFFFFC107), 'hex': '#FFC107'}, // Amber/Material Yellow - vàng đậm, ấm
      {'name': 'Nâu Đất', 'color': Color(0xFF8B4513), 'hex': '#8B4513'}, // SaddleBrown - Giữ nguyên Nâu
      {'name': 'Cam Sẫm', 'color': Color(0xFFFF8C00), 'hex': '#FF8C00'}, // DarkOrange - Cam đậm hơn
    ],
  };

  // Các mối quan hệ tương sinh, tương khắc giữa các ngũ hành
  static const Map<String, List<String>> hanhRelationships = {
    'tương sinh': ['kim-thủy', 'thủy-mộc', 'mộc-hỏa', 'hỏa-thổ', 'thổ-kim'],
    'tương khắc': ['kim-mộc', 'mộc-thổ', 'thổ-thủy', 'thủy-hỏa', 'hỏa-kim'],
  };

  // Bảng con số may mắn theo ngũ hành Hà Đồ
  static const Map<String, List<int>> hanhToLuckyNumbers = {
    'kim': [4, 9],
    'mộc': [3, 8],
    'thủy': [1, 6],
    'hỏa': [2, 7],
    'thổ': [0, 5], // Hà đồ Thổ là 0, 5
  };

  /// Tính toán màu may mắn dựa trên ngày sinh và ngày hiện tại
  static List<Map<String, dynamic>> getLuckyColors(
      DateTime birthDate, DateTime selectedDate) {
    try {
      final birthYearInfo = _getHanhInfo(birthDate, true);
      final String userHanh =
          birthYearInfo['napAmHanh'].toString().toLowerCase();

      final List<Map<String, dynamic>> luckyColors = [];

      // 1. Màu Bản Mệnh
      luckyColors.addAll(hanhToColors[userHanh] ?? []);

      // 2. Màu Tương Sinh (Hành sinh ra mình)
      String? sinhHanh;
      for (final relation in hanhRelationships['tương sinh']!) {
        final parts = relation.split('-');
        if (parts.length == 2 && parts[1] == userHanh) {
          sinhHanh = parts[0];
          break;
        }
      }
      if (sinhHanh != null) {
        luckyColors.addAll(hanhToColors[sinhHanh] ?? []);
      }

      // // 3. (Tùy chọn) Bỏ Màu Sinh Xuất (Hành mình sinh ra) - Giữ lại nếu bạn muốn nhiều lựa chọn hơn
      // String? xuatHanh;
      // for (final relation in hanhRelationships['tương sinh']!) {
      //   final parts = relation.split('-');
      //   if (parts.length == 2 && parts[0] == userHanh) {
      //     xuatHanh = parts[1];
      //     break;
      //   }
      // }
      // if (xuatHanh != null) {
      //   luckyColors.addAll(hanhToColors[xuatHanh] ?? []);
      // }

      // Loại bỏ trùng lặp (nếu có do thêm từ nhiều nguồn)
      final uniqueColors = <Map<String, dynamic>>[];
      final seenNames = <String>{};
      for (final color in luckyColors) {
        if (seenNames.add(color['name'])) {
          // Chỉ thêm nếu tên màu chưa có
          uniqueColors.add(color);
        }
      }

      final seedValue = selectedDate.year * 10000 +
          selectedDate.month * 100 +
          selectedDate.day;
      final random = Random(seedValue);
      uniqueColors.shuffle(random);

      return uniqueColors.take(5).map((color) {
        return {
          'name': color['name'],
          'color': color['color'],
          'hex': color['hex'],
          'hanh': _findHanhByColor(color['name'])
        };
      }).toList();
    } catch (e) {
      LoggerUtils.error('LuckyElements: Error calculating lucky colors', e);
      return [
        {
          'name': 'Xanh Lá',
          'color': const Color(0xFF00A651),
          'hex': '#00A651',
          'hanh': 'Mộc'
        },
        {
          'name': 'Vàng',
          'color': const Color(0xFFFFFF00),
          'hex': '#FFFF00',
          'hanh': 'Thổ'
        },
        {
          'name': 'Trắng',
          'color': const Color(0xFFFFFFFF),
          'hex': '#FFFFFF',
          'hanh': 'Kim'
        },
      ];
    }
  }

  /// Tìm ngũ hành tương ứng với tên màu
  static String _findHanhByColor(String colorName) {
    for (final entry in hanhToColors.entries) {
      for (final color in entry.value) {
        if (color['name'] == colorName) {
          return entry.key == 'kim'
              ? 'Kim'
              : entry.key == 'mộc'
                  ? 'Mộc'
                  : entry.key == 'thủy'
                      ? 'Thủy'
                      : entry.key == 'hỏa'
                          ? 'Hỏa'
                          : 'Thổ';
        }
      }
    }
    return 'Kim';
  }

  /// Tính 3 con số may mắn dựa trên phương pháp ưu tiên
  static List<int> getLuckyNumbers(UserData user, DateTime selectedDate) {
    if (user.birthDate == null) {
      LoggerUtils.warning("LuckyElements: Thiếu ngày sinh để tính số may mắn.");
      return [3, 7, 9];
    }

    try {
      final DateTime birthDate = user.birthDate!;
      final String gender = user.gender;
      final Set<int> prioritizedLuckyNumbers = {};

      // Ưu tiên 1: Số theo Hành Nạp Âm (Hà Đồ)
      final birthYearInfo = _getHanhInfo(birthDate, true);
      final String userHanh =
          birthYearInfo['napAmHanh'].toString().toLowerCase();
      prioritizedLuckyNumbers.addAll(hanhToLuckyNumbers[userHanh] ?? []);
      // LoggerUtils.debug("LuckyNumbers - Hà Đồ ($userHanh): ${hanhToLuckyNumbers[userHanh]} -> Set: $prioritizedLuckyNumbers");

      // Ưu tiên 2: Số Đường Đời (Life Path)
      final int lifePath = _calculateLifePath(birthDate);
      prioritizedLuckyNumbers.add(lifePath);
      // LoggerUtils.debug("LuckyNumbers - Life Path: $lifePath -> Set: $prioritizedLuckyNumbers");

      // Ưu tiên 3: Số Kua (Cần Giới Tính)
      final bool isMale = (gender.toLowerCase() == 'male');
      final int kuaNumber = _calculateKuaNumber(birthDate, isMale);
      prioritizedLuckyNumbers.add(kuaNumber);
      // LoggerUtils.debug("LuckyNumbers - Kua ($gender): $kuaNumber -> Set: $prioritizedLuckyNumbers");

      // Ưu tiên 4: Số Can/Chi (Nếu chưa đủ 3 số)
      if (prioritizedLuckyNumbers.length < 3) {
        final String dayCan =
            LunarService.getCanChiDay(selectedDate).split(' ')[0];
        int canNumber = TimeConstant.hangCan.indexOf(dayCan) + 1;
        canNumber = _reduceSingleDigit(canNumber);
        if (canNumber > 0) {
          prioritizedLuckyNumbers.add(canNumber);
          //  LoggerUtils.debug("LuckyNumbers - Can Ngày ($dayCan): $canNumber -> Set: $prioritizedLuckyNumbers");
        }
      }
      if (prioritizedLuckyNumbers.length < 3) {
        final String birthChi =
            LunarService.getCanChiYear(birthDate).split(' ')[1];
        int chiNumber = TimeConstant.hangChi.indexOf(birthChi) + 1;
        chiNumber = _reduceSingleDigit(chiNumber);
        if (chiNumber > 0) {
          prioritizedLuckyNumbers.add(chiNumber);
          //  LoggerUtils.debug("LuckyNumbers - Chi Năm Sinh ($birthChi): $chiNumber -> Set: $prioritizedLuckyNumbers");
        }
      }

      // Xử lý cuối cùng
      List<int> result = prioritizedLuckyNumbers
          .where((num) => num >= 0 && num <= 9)
          .toList(); // Giữ lại số 0 từ Hà Đồ Thổ

      // Bổ sung nếu vẫn thiếu (ưu tiên các số chưa có)
      final backupNumbers = [
        1,
        6,
        2,
        7,
        3,
        8,
        4,
        9,
        5,
        0
      ]; // Thứ tự Thủy, Hỏa, Mộc, Kim, Thổ
      int currentBackupIndex = 0;
      while (result.length < 3 && currentBackupIndex < backupNumbers.length) {
        final numToAdd = backupNumbers[currentBackupIndex];
        if (!result.contains(numToAdd)) {
          result.add(numToAdd);
          // LoggerUtils.debug("LuckyNumbers - Bổ sung dự phòng: $numToAdd");
        }
        currentBackupIndex++;
      }

      final seedValue = selectedDate.year * 10000 +
          selectedDate.month * 100 +
          selectedDate.day;
      final random = Random(seedValue);
      result.shuffle(random);
      // LoggerUtils.debug("LuckyNumbers - Final Shuffled: $result");

      return result.take(3).toList();
    } catch (e, s) {
      LoggerUtils.error(
          'LuckyElements: Lỗi khi tính số may mắn (đã refactor)', e, s);
      return [3, 7, 9];
    }
  }

  /// Tính số KUA dựa trên năm sinh và giới tính
  static int _calculateKuaNumber(DateTime birthDate, bool isMale) {
    final lunarBirth = LunarService.getSolarToLunar(birthDate);
    int year = lunarBirth.year;

    int sum = 0;
    while (year > 0) {
      sum += year % 10;
      year ~/= 10;
    }
    int baseNumber = _reduceSingleDigit(sum);

    int kuaNumber;
    if (isMale) {
      kuaNumber = 11 - baseNumber;
    } else {
      kuaNumber = baseNumber + 4;
    }

    kuaNumber = _reduceSingleDigit(kuaNumber);

    if (kuaNumber == 5) {
      kuaNumber = isMale ? 2 : 8;
    }
    if (kuaNumber == 0) kuaNumber = 9; // Theo quy ước phổ biến

    return kuaNumber;
  }

  /// Lấy thông tin ngũ hành từ ngày
  static Map<String, dynamic> _getHanhInfo(DateTime date, bool isYearHanh) {
    try {
      if (isYearHanh) {
        final String canChiYear = LunarService.getCanChiYear(date);
        return _getNapAmFromCanChi(canChiYear);
      } else {
        return LunarService.getHanhOfDay(date);
      }
    } catch (e) {
      LoggerUtils.error('LuckyElements: Error getting hanh info', e);
      return {
        'canChi': isYearHanh
            ? LunarService.getCanChiYear(date)
            : LunarService.getCanChiDay(date),
        'canHanh': 'Kim',
        'chiHanh': 'Thủy',
        'napAm': 'Bích Thượng Thổ',
        'napAmHanh': 'Thổ'
      };
    }
  }

  /// Lấy Nạp Âm và Ngũ Hành từ Can Chi
  static Map<String, dynamic> _getNapAmFromCanChi(String canChi) {
    final napAmData = TimeConstant.napAmTable[canChi] ??
        {"napAm": "Bích Thượng Thổ", "hanh": "Thổ"};

    final parts = canChi.split(' ');
    if (parts.length != 2) {
      return {
        'canChi': canChi,
        'canHanh': 'Kim',
        'chiHanh': 'Thủy',
        'napAm': napAmData['napAm'] ?? 'Bích Thượng Thổ',
        'napAmHanh': napAmData['hanh'] ?? 'Thổ',
      };
    }

    final can = parts[0];
    final chi = parts[1];

    return {
      'canChi': canChi,
      'canHanh': TimeConstant.canToHanh[can] ?? 'Kim',
      'chiHanh': TimeConstant.chiToHanh[chi] ?? 'Thủy',
      'napAm': napAmData['napAm'] ?? 'Bích Thượng Thổ',
      'napAmHanh': napAmData['hanh'] ?? 'Thổ',
    };
  }


  /// Giảm số xuống thành 1 chữ số (0-9), xử lý số 0 -> 9
  static int _reduceSingleDigit(int number) {
    if (number < 0) number = -number;
    if (number == 0) return 9; // Kua số 0 quy về 9

    while (number > 9) {
      int sum = 0;
      String digits = number.toString();
      for (int i = 0; i < digits.length; i++) {
        sum += int.parse(digits[i]);
      }
      number = sum;
    }
    return number == 0 ? 9 : number; // Đảm bảo không bao giờ trả về 0
  }

  /// Tính Life Path Number từ ngày sinh
  static int _calculateLifePath(DateTime birthDate) {
    int day = birthDate.day;
    int month = birthDate.month;
    int year = birthDate.year;

    int reducedDay = _reduceSingleDigit(day);
    int reducedMonth = _reduceSingleDigit(month);
    int reducedYear = _reduceSingleDigit(year);

    int sum = reducedDay + reducedMonth + reducedYear;
    return _reduceSingleDigit(sum);
  }

  // Hàm _getNumberFromStar không còn được sử dụng trong logic mới
}
