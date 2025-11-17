import 'dart:math';
import 'dart:ui';
import 'package:bluebyte_flutter_getx/app/modules/detail/services/calculator/chi_relation_service.dart';
import 'package:bluebyte_flutter_getx/app/modules/detail/services/calculator/ngu_hanh_relation_service.dart';
import 'package:bluebyte_flutter_getx/app/modules/detail/services/constants/enums.dart';
import 'package:bluebyte_flutter_getx/app/modules/detail/services/constants/solar_terms_constants.dart';
import 'package:bluebyte_flutter_getx/app/modules/detail/services/mini_services/ngoc_hap_service.dart';
import 'package:bluebyte_flutter_getx/app/modules/detail/services/constants/time_constants.dart';
import 'package:bluebyte_flutter_getx/app/utils/logger_utils.dart';
import 'package:full_calender/enums/language_name.dart';
import 'package:full_calender/enums/time_zone.dart';
import 'package:full_calender/full_calender.dart';
import 'package:full_calender/full_calender_extension.dart';
import 'package:full_calender/models/lunar_date_time.dart';
import 'package:intl/intl.dart';

class LunarService {
  // Cache ngày âm lịch
  static final Map<String, LunarDateTime> _lunarDateCache = {};

  // Chuyển dương lịch sang âm lịch
  static LunarDateTime getSolarToLunar(DateTime date) {
    final localDate = date.toLocal();
    final key = '${localDate.year}-${localDate.month}-${localDate.day}';

    if (_lunarDateCache.containsKey(key)) {
      return _lunarDateCache[key]!;
    }

    try {
      final fullCalender = FullCalender(
        date: localDate,
        timeZone: TimeZone.vietnamese.timezone,
      );
      _lunarDateCache[key] = fullCalender.lunarDate;
      return fullCalender.lunarDate;
    } catch (e) {
      LoggerUtils.error('Error converting to lunar date', e);
      final defaultLunar =
          LunarDateTime(day: 1, month: 1, year: localDate.year);
      _lunarDateCache[key] = defaultLunar;
      return defaultLunar;
    }
  }

  // Xóa cache
  static void clearCache() {
    _lunarDateCache.clear();
    _lunarMonthDaysCache.clear();
  }

  // Giới hạn kích thước cache
  static void limitCacheSize([int maxSize = _maxCacheSize]) {
    while (_lunarDateCache.length > maxSize) {
      _lunarDateCache.remove(_lunarDateCache.keys.first);
    }
    while (_lunarMonthDaysCache.length > maxSize) {
      _lunarMonthDaysCache.remove(_lunarMonthDaysCache.keys.first);
    }
  }

  // Lấy can chi ngày
  static String getCanChiDay(DateTime date) => getSolarToLunar(date.toLocal())
      .stemBranchOfDay
      .name(LanguageName.vietNam);

  // Lấy can chi tháng
  static String getCanChiMonth(DateTime date) => getSolarToLunar(date.toLocal())
      .stemBranchOfMonth
      .name(LanguageName.vietNam);

  // Lấy can chi năm
  static String getCanChiYear(DateTime date) => getSolarToLunar(date.toLocal())
      .stemBranchOfYear
      .name(LanguageName.vietNam);

  // Hàm lấy icon của địa chi
  // Hàm lấy icon của địa chi (SỬA ĐỔI)
  static String getChiIcon(String chi) {
    // Trả về đường dẫn ảnh, hoặc đường dẫn placeholder nếu không tìm thấy
    return TimeConstant.chiIcons[chi] ?? TimeConstant.defaultChiIconPath;
  }

  // Hàm _getCanChiWithIcon (SỬA ĐỔI NHẸ để rõ ràng hơn với đường dẫn)
  static String _getCanChiWithIcon(String canChi, String prefix) {
    final parts = canChi.split(' ');
    if (parts.length != 2) return canChi; // Trả về gốc nếu không đúng định dạng

    // Lấy đường dẫn icon thay vì ký tự unicode
    final String chiIconPath = getChiIcon(parts[1]); // parts[1] là Địa Chi

    // Ghép chuỗi, phần icon giờ là đường dẫn
    return '$chiIconPath $prefix ${parts[0]} ${parts[1]}';
  }

// Cập nhật các hàm
  static String getCanChiDayWithIcon(DateTime date) =>
      _getCanChiWithIcon(getCanChiDay(date), 'Ngày');

  static String getCanChiMonthWithIcon(DateTime date) =>
      _getCanChiWithIcon(getCanChiMonth(date), 'Tháng');

  static String getCanChiYearWithIcon(DateTime date) =>
      _getCanChiWithIcon(getCanChiYear(date), 'Năm');

  // --- LOGIC HOÀNG ĐẠO / HẮC ĐẠO MỚI (REVISED - Theo bảng chính xác) ---

  static int _getMonthGroupHDHD(int lunarMonth) {
    // ... (giữ nguyên hàm này) ...
    if (lunarMonth < 1 || lunarMonth > 12) {
      LoggerUtils.warning(
          "Invalid lunar month for month group calculation: $lunarMonth");
      return 1;
    }
    if (lunarMonth == 1 || lunarMonth == 7) return 1;
    if (lunarMonth == 2 || lunarMonth == 8) return 2;
    if (lunarMonth == 3 || lunarMonth == 9) return 3;
    if (lunarMonth == 4 || lunarMonth == 10) return 4;
    if (lunarMonth == 5 || lunarMonth == 11) return 5;
    return 6; // Months 6 & 12
  }

  // --- HÀM XÁC ĐỊNH LOẠI NGÀY (REVISED) ---
  static DayType getDayType(DateTime date) {
    try {
      final lunarDate = getSolarToLunar(date.toLocal());
      final lunarMonth = lunarDate.month;
      final canChiDay = getCanChiDay(date);
      final parts = canChiDay.split(' ');
      if (parts.length != 2) {
        LoggerUtils.error("Invalid Can Chi format for day: $canChiDay");
        return DayType.ERROR;
      }
      final dayChi = parts[1];

      if (!TimeConstant.hangChi.contains(dayChi)) {
        LoggerUtils.error("Invalid Day Chi: $dayChi");
        return DayType.ERROR;
      }

      final monthGroup = _getMonthGroupHDHD(lunarMonth);

      // Duyệt qua bảng accurateHoangHacDaoTable để tìm xem Chi/Tháng này có khớp không
      for (var entry in TimeConstant.accurateHoangHacDaoTable.entries) {
        final thanName = entry.key;
        final monthData = entry.value;

        // Kiểm tra xem nhóm tháng hiện tại có trong dữ liệu của Thần này không
        if (monthData.containsKey(monthGroup)) {
          // Kiểm tra xem Chi trong bảng có khớp với Chi của ngày đang xét không
          if (monthData[monthGroup] == dayChi) {
            // Nếu khớp -> Tìm thấy Thần -> Xác định loại ngày
            final bool? isHoangDao = TimeConstant.accurateDeityTypes[thanName];
            if (isHoangDao == null) {
              // Lỗi nếu Thần có trong bảng tra cứu nhưng không có trong bảng loại
              LoggerUtils.error(
                  "Deity type not defined for '$thanName' in accurateDeityTypes map.");
              return DayType.ERROR;
            }
            return isHoangDao ? DayType.HOANG_DAO : DayType.HAC_DAO;
          }
        }
      }

      // Nếu duyệt hết bảng mà không tìm thấy khớp -> Ngày Bình Thường
      // LoggerUtils.debug("Date: $date, LunarMonth: $lunarMonth, DayChi: $dayChi, MonthGroup: $monthGroup -> No match found => BINH_THUONG");
      return DayType.BINH_THUONG;
    } catch (e, s) {
      LoggerUtils.error('Error determining Day Type (Accurate)', e, s);
      return DayType.ERROR;
    }
  }
  // --- KẾT THÚC HÀM getDayType (REVISED) ---

  // --- HÀM LẤY TÊN THẦN (REVISED) ---
  static String getDeityName(DateTime date) {
    try {
      final lunarDate = getSolarToLunar(date.toLocal());
      final lunarMonth = lunarDate.month;
      final canChiDay = getCanChiDay(date);
      final parts = canChiDay.split(' ');
      if (parts.length != 2) {
        LoggerUtils.error("Invalid Can Chi format for day: $canChiDay");
        return "Không xác định";
      }
      final dayChi = parts[1];

      if (!TimeConstant.hangChi.contains(dayChi)) {
        LoggerUtils.error("Invalid Day Chi: $dayChi");
        return "Không xác định";
      }

      final monthGroup = _getMonthGroupHDHD(lunarMonth);

      // Duyệt qua bảng để tìm Thần khớp
      for (var entry in TimeConstant.accurateHoangHacDaoTable.entries) {
        final thanName = entry.key;
        final monthData = entry.value;

        if (monthData.containsKey(monthGroup) &&
            monthData[monthGroup] == dayChi) {
          // Tìm thấy khớp -> trả về tên Thần
          return thanName;
        }
      }

      // Không tìm thấy khớp -> Ngày Bình Thường -> Không có tên Thần
      return "...";
    } catch (e, s) {
      LoggerUtils.error('Error getting Accurate Deity Name', e, s);
      return "Không xác định";
    }
  }
  // --- KẾT THÚC getDeityName (REVISED) ---

  static bool isLuckyDay(DateTime date) =>
      getSolarToLunar(date.toLocal()).isLuckyDay;

  // Lấy tuổi xung
  static String getConflictAge(DateTime date) =>
      TimeConstant.listAgeConflict[getCanChiDay(date.toLocal())] ?? '';

  // Lấy ngày xuất hành
  static String getDayDaily(DateTime date) {
    final lunarDate = getSolarToLunar(date.toLocal());
    return _getXuatHanhType(lunarDate.month, lunarDate.day, date);
  }

// Xác định loại ngày xuất hành theo công thức Khổng Minh
  static String _getXuatHanhType(int lunarMonth, int lunarDay, DateTime date) {
    // Xác định nhóm tháng
    final int monthGroup = _getMonthGroupNXH(lunarMonth);

    // Áp dụng công thức dựa vào nhóm tháng
    return _calculateXuatHanhDay(monthGroup, lunarDay, date);
  }

// Xác định nhóm tháng: 1,4,7,10 | 2,5,8,11 | 3,6,9,12
  static int _getMonthGroupNXH(int lunarMonth) {
    return (lunarMonth - 1) % 3 + 1;
  }

// Tính toán ngày xuất hành dựa trên nhóm tháng và ngày
  static String _calculateXuatHanhDay(int monthGroup, int day, DateTime date) {
    // Lấy số ngày thực tế của tháng âm lịch
    int maxDays = getDaysInLunarMonthFromDate(date);

    // Chuẩn hóa day trong khoảng 1 đến maxDays
    if (day > maxDays) {
      day = day % maxDays; // Điều chỉnh day nếu vượt quá maxDays
    }
    if (day == 0) {
      day = maxDays; // Đảm bảo day không bao giờ là 0
    }

    // Tính số dư khi chia cho 8 (chu kỳ 8 ngày)
    // Hạn chế các ngày > 30
    int dayMod8 = (day - 1) % 8 + 1;

    switch (monthGroup) {
      case 1: // Tháng 1,4,7,10
        switch (day % 6) {
          case 0:
            return "Hảo Thương"; // 6, 12, 18, 24, 30
          case 5:
            return "Đạo Tặc"; // 5, 11, 17, 23, 29
          case 4:
            return "Thuần Dương"; // 4, 10, 16, 22, 28
          case 1:
            return "Đường Phong"; // 1, 7, 13, 19, 25
          case 2:
            return "Kim Thổ"; // 2, 8, 14, 20, 26
          case 3:
            return "Kim Dương"; // 3, 9, 15, 21, 27
          default:
            return "";
        }
      case 2: // Tháng 2,5,8,11
        if (day % 8 == 1) return "Thiên Đạo"; // 1, 9, 17, 25
        if (day % 8 == 0) return "Thiên Thương"; // 8, 16, 24
        if (day % 8 == 7) return "Thiên Hầu"; // 7, 15, 23
        if (day % 8 == 6) return "Thiên Dương"; // 6, 14, 22, 30
        if (day % 8 == 2) return "Thiên Môn"; // 2, 10, 18, 26
        if (day % 8 == 3) return "Thiên Đường"; // 3, 11, 19, 27
        if (day % 8 == 4) return "Thiên Tài"; // 4, 12, 20, 28
        if (day % 8 == 5) return "Thiên Tặc"; // 5, 13, 21, 29
        return "";
      case 3: // Tháng 3,6,9,12
        if (day % 8 == 2) return "Bạch Hổ Đầu"; // 2, 10, 18, 26
        if (day % 8 == 3) return "Bạch Hổ Kiếp"; // 3, 11, 19, 27
        if (day % 8 == 4) return "Bạch Hổ Túc"; // 4, 12, 20, 28
        if (day % 8 == 5) return "Huyền Vũ"; // 5, 13, 21, 29
        if (day % 8 == 1) return "Chu Tước"; // 1, 9, 17, 25
        if (day % 8 == 0) return "Thanh Long Túc"; // 8, 16, 24
        if (day % 8 == 7) return "Thanh Long Kiếp"; // 7, 15, 23
        if (day % 8 == 6) return "Thanh Long Đầu"; // 6, 14, 22, 30
        return "";
      default:
        return "";
    }
  }

// Nên cập nhật TimeConstant.xuatHanhByMonth theo bảng công thức chuẩn xác
  static void updateXuatHanhData() {
    // Map mới để lưu trữ dữ liệu ngày xuất hành chính xác hơn
    Map<int, Map<int, String>> completeXuatHanhData = {};

    // Tháng 1,4,7,10
    for (int month in [1, 4, 7, 10]) {
      Map<int, String> monthData = {};
      for (int day = 1; day <= 30; day++) {
        switch (day % 6) {
          case 0:
            monthData[day] = "Hảo Thương";
            break;
          case 5:
            monthData[day] = "Đạo Tặc";
            break;
          case 4:
            monthData[day] = "Thuần Dương";
            break;
          case 1:
            monthData[day] = "Đường Phong";
            break;
          case 2:
            monthData[day] = "Kim Thổ";
            break;
          case 3:
            monthData[day] = "Kim Dương";
            break;
        }
      }
      completeXuatHanhData[month] = monthData;
    }

    // Tháng 2,5,8,11
    for (int month in [2, 5, 8, 11]) {
      Map<int, String> monthData = {};
      for (int day = 1; day <= 30; day++) {
        switch (day % 8) {
          case 1:
            monthData[day] = "Thiên Đạo";
            break;
          case 0:
            monthData[day] = "Thiên Thương";
            break;
          case 7:
            monthData[day] = "Thiên Hầu";
            break;
          case 6:
            monthData[day] = "Thiên Dương";
            break;
          case 2:
            monthData[day] = "Thiên Môn";
            break;
          case 3:
            monthData[day] = "Thiên Đường";
            break;
          case 4:
            monthData[day] = "Thiên Tài";
            break;
          case 5:
            monthData[day] = "Thiên Tặc";
            break;
        }
      }
      completeXuatHanhData[month] = monthData;
    }

    // Tháng 3,6,9,12
    for (int month in [3, 6, 9, 12]) {
      Map<int, String> monthData = {};
      for (int day = 1; day <= 30; day++) {
        switch (day % 8) {
          case 2:
            monthData[day] = "Bạch Hổ Đầu";
            break;
          case 3:
            monthData[day] = "Bạch Hổ Kiếp";
            break;
          case 4:
            monthData[day] = "Bạch Hổ Túc";
            break;
          case 5:
            monthData[day] = "Huyền Vũ";
            break;
          case 1:
            monthData[day] = "Chu Tước";
            break;
          case 0:
            monthData[day] = "Thanh Long Túc";
            break;
          case 7:
            monthData[day] = "Thanh Long Kiếp";
            break;
          case 6:
            monthData[day] = "Thanh Long Đầu";
            break;
        }
      }
      completeXuatHanhData[month] = monthData;
    }

    // Cập nhật dữ liệu nếu có thể
    // TimeConstant.xuatHanhByMonth = completeXuatHanhData;
    // Hoặc sử dụng dữ liệu này thay thế cho xuatHanhByMonth hiện tại
  }

// Các phương thức khác vẫn giữ nguyên
// Phương thức kiểm tra tốt/xấu dựa trên loại ngày xuất hành
  static String convertXuatHanh(String loaiNgay) {
    final ngayTot = [
      "Hảo Thương",
      "Thuần Dương",
      "Đường Phong",
      "Kim Dương",
      "Thiên Thương",
      "Thiên Dương",
      "Thiên Môn",
      "Thiên Đường",
      "Thiên Tài",
      "Bạch Hổ Đầu",
      "Bạch Hổ Kiếp",
      "Thanh Long Kiếp",
      "Thanh Long Đầu"
    ];
    final ngayXau = [
      "Đạo Tặc",
      "Kim Thổ",
      "Thiên Đạo",
      "Thiên Hầu",
      "Thiên Tặc",
      "Bạch Hổ Túc",
      "Huyền Vũ",
      "Chu Tước",
      "Thanh Long Túc"
    ];
    if (ngayTot.contains(loaiNgay)) return "tot";
    if (ngayXau.contains(loaiNgay)) return "xau";
    return "";
  }

// Thêm phương thức kiểm tra xung khắc giữa ngày xuất hành và tuổi
  static bool isCompatibleWithAge(DateTime date, String canChiYear) {
    final xuatHanhType = getDayDaily(date);
    final ageConflict = getConflictAge(date);

    // Kiểm tra nếu tuổi của người xuất hành nằm trong danh sách xung khắc
    return !ageConflict.split(', ').contains(canChiYear);
  }

// Phương thức để lấy danh sách tất cả các ngày tốt để xuất hành trong tháng
  static List<DateTime> getGoodDaysForTravel(
      int year, int month, String canChiYear) {
    List<DateTime> goodDays = [];

    // Xác định số ngày trong tháng
    final lastDay = DateTime(year, month + 1, 0).day;

    for (int day = 1; day <= lastDay; day++) {
      final date = DateTime(year, month, day);
      final xuatHanhType = getDayDaily(date);

      // Kiểm tra nếu là ngày tốt và không xung khắc với tuổi
      if (convertXuatHanh(xuatHanhType) == "tot" &&
          isCompatibleWithAge(date, canChiYear)) {
        goodDays.add(date);
      }
    }

    return goodDays;
  }

  static String getNgayToHTML(String ngay) {
    return TimeConstant.xuatHanhDescription[ngay] ?? '';
  }

  static String getNgayRating(String ngay) {
    return TimeConstant.xuatHanhRating[ngay] ?? '';
  }

  /// Lấy thông tin Khổng Minh Lục Diệu cho một ngày cụ thể
  static Map<String, dynamic> getKhongMinhLucDieuDayInfo(DateTime date) {
    try {
      final lunarDate = getSolarToLunar(date.toLocal());
      final lunarMonth = lunarDate.month;
      final lunarDay = lunarDate.day;

      // Lấy tên Lục Diệu của ngày mùng 1
      final String? startName = TimeConstant.lucDieuDayStart[lunarMonth];
      if (startName == null) {
        throw Exception(
            'Không tìm thấy ngày bắt đầu Lục Diệu cho tháng $lunarMonth');
      }

      // Tìm index của ngày bắt đầu trong chu kỳ
      final int startIndex = TimeConstant.lucDieuOrder.indexOf(startName);
      if (startIndex == -1) {
        throw Exception(
            'Tên ngày bắt đầu "$startName" không hợp lệ trong chu kỳ Lục Diệu.');
      }

      // Tính index của ngày cần xem (ngày 1 tương ứng startIndex, ngày 2 tương ứng startIndex+1,...)
      // Dùng (lunarDay - 1) vì ngày 1 đã là startIndex
      final int dayIndex = (startIndex + lunarDay - 1) % 6;

      // Lấy tên Lục Diệu của ngày cần xem
      final String dayName = TimeConstant.lucDieuOrder[dayIndex];

      // Lấy chi tiết thông tin của ngày Lục Diệu đó
      final Map<String, dynamic> details =
          TimeConstant.lucDieuDayDetails[dayName] ??
              {
                'rating': 'Không xác định',
                'description': 'Lỗi tra cứu chi tiết.',
                'poem': '',
                'icon': '❓'
              };

      // Trả về kết quả hoàn chỉnh
      return {
        'name': dayName,
        ...details, // Spread operator để gộp các chi tiết vào map kết quả
      };
    } catch (e, stackTrace) {
      LoggerUtils.error(
          'Lỗi khi tính Khổng Minh Lục Diệu (Ngày)', e, stackTrace);
      // Trả về giá trị mặc định/lỗi
      return {
        'name': 'Lỗi',
        'rating': 'Không xác định',
        'description': 'Không thể tính toán Lục Diệu cho ngày này.',
        'poem': '',
        'icon': '❓'
      };
    }
  }

  // Lấy icon cho ngày xuất hành
  static String getXuatHanhIcon(String ngay) {
    return TimeConstant.xuatHanhIcons[ngay] ?? '📅';
  }

  // Lấy giờ hoàng đạo
  static List<String> getGioHoangDao(DateTime date) => _gioHoangDaoByNgay(
      getCanChiDay(date.toLocal()).split(' ')[1].toLowerCase());

  // Lấy giờ hắc đạo
  static List<String> getGioHacDao(DateTime date) => _gioHacDaoByNgay(
      getCanChiDay(date.toLocal()).split(' ')[1].toLowerCase());

  // Giờ hoàng đạo theo chi ngày
  static List<String> _gioHoangDaoByNgay(String chiNgay) {
    final key = TimeConstant.hoangDaoByChi.keys.firstWhere(
      (k) => k.split('|').contains(chiNgay),
      orElse: () => "",
    );
    return TimeConstant.hoangDaoByChi[key] ?? [];
  }

  // Giờ hắc đạo theo chi ngày
  static List<String> _gioHacDaoByNgay(String chiNgay) {
    final key = TimeConstant.hacDaoByChi.keys.firstWhere(
      (k) => k.split('|').contains(chiNgay),
      orElse: () => "",
    );
    return TimeConstant.hacDaoByChi[key] ?? [];
  }

  // Chuỗi giờ hoàng đạo/hắc đạo
  static String getGioHDTrongNgayTXT(DateTime date,
      {bool isHoangDao = true, bool isMini = false}) {
    final gioList = isHoangDao ? getGioHoangDao(date) : getGioHacDao(date);
    return gioList
        .map((gio) => isMini
            ? TimeConstant.khungGioMini[gio]
            : TimeConstant.khungGio[gio])
        .where((time) => time != null)
        .join(', ');
  }

  static List<Map<String, dynamic>> _formatGio(
      List<String> gioList, bool isHoangDao) {
    return gioList.map((gio) {
      final zodiac = gio[0].toUpperCase() + gio.substring(1);
      return {
        'zodiac': zodiac,
        'time': TimeConstant.khungGio[gio]
                ?.split(' ')[1]
                .replaceAll(RegExp(r'[()]'), '') ??
            '',
      };
    }).toList();
  }

  // Giờ hoàng đạo định dạng với hình ảnh
  static List<Map<String, dynamic>> getFormattedGioHoangDao(DateTime date) =>
      _formatGio(getGioHoangDao(date), true);

  // Giờ hắc đạo định dạng với hình ảnh
  static List<Map<String, dynamic>> getFormattedGioHacDao(DateTime date) =>
      _formatGio(getGioHacDao(date), false);

  //todo: Lấy thông tin tiết khí (tên, khoảng ngày) từ dữ liệu tiền tính toán.
  /// Sử dụng logic thời gian chính xác.
  static Map<String, dynamic> getTietKhiInfoForDisplay(DateTime date) {
    // *** Gọi hàm lấy tiết khí theo THỜI GIAN CHÍNH XÁC ***
    final termData = SolarTermsConstants.getSolarTermForDayCalculation(date);

    if (termData != null) {
      final name = termData['name'] as String? ?? 'Không xác định';
      final icon = TimeConstant.tietKhiIcons[name] ?? '❓';
      final startTimeString = termData['startTimeLocal'] as String?;
      final endTimeString = termData['endTimeLocal'] as String?;

      String displayRange = '(N/A)';
      try {
        if (startTimeString != null) {
          final startTime = DateTime.parse(startTimeString).toLocal();
          // **THAY ĐỔI FORMATTER NGÀY Ở ĐÂY**
          final DateFormat dayMonthFormatter =
              DateFormat('d/M'); // Chỉ lấy ngày/tháng
          final DateFormat timeFormatter = DateFormat('HH:mm'); // Formatter cho giờ phút
          final String displayStartDate = dayMonthFormatter.format(startTime);
          final String displayStartTime = timeFormatter.format(startTime);

          if (endTimeString != null) {
            final endTime = DateTime.parse(endTimeString).toLocal();
            final String displayEndDate = dayMonthFormatter.format(endTime);
            final String displayEndTime = timeFormatter.format(endTime);
            // **THAY ĐỔI CÁCH TẠO CHUỖI HIỂN THỊ Ở ĐÂY**
            displayRange = '(từ $displayStartTime ngày $displayStartDate đến $displayEndTime ngày $displayEndDate DL)';
          } else {
            // **THAY ĐỔI CÁCH TẠO CHUỖI HIỂN THỊ KHI CHỈ CÓ NGÀY BẮT ĐẦU (ÍT XẢY RA VỚI TIẾT KHÍ)**
            displayRange = '(từ $displayStartTime ngày $displayStartDate DL)';
          }
        }
      } catch (e) {
        LoggerUtils.error(
            "Lỗi parse/format ngày giờ tiết khí chi tiết cho '$name'", e);
        displayRange = '(Lỗi định dạng)';
      }

      return {
        'name': name,
        'icon': icon,
        'displayRange': displayRange,
      };
    } else {
      LoggerUtils.error(
          "Không tìm thấy dữ liệu tiết khí để hiển thị cho ngày: ${date.toIso8601String()}");
      return {
        'name': 'Không xác định',
        'icon': '❓',
        'displayRange': '(Ngoài phạm vi)',
      };
    }
  }

  /// [FINAL - FOR TRUC CALCULATION] Hàm lấy tên tiết khí để TÍNH TOÁN TRỰC (dùng tiết khí của ngày).
  static String _getTietKhiNameForTrucCalculation(DateTime date) {
    // *** Gọi hàm lấy tiết khí theo logic NGÀY ***
    final termData = SolarTermsConstants.getSolarTermForPreciseTime(
        date); //getSolarTermForDayCalculation(date);
    if (termData == null) {
      LoggerUtils.error(
          '[TRUC CALC] Không thể xác định Tiết Khí cho tính toán Trực ngày ${date.toIso8601String()}');
      // Trả về tên mặc định an toàn để tránh lỗi ở hàm _getKienChi
      return 'Lập Xuân';
    }
    return termData['name'] as String? ??
        'Lập Xuân'; // Trả về mặc định nếu name null
  }

  // Hàm lấy tên tiết khí CHUNG (sử dụng logic hiển thị)
  static String getTietKhiName(DateTime date) {
    // Mặc định hàm getTietKhiName sẽ trả về tên theo logic hiển thị (thời gian chính xác)
    final info = _getTietKhiNameForTrucCalculation(date);
    return info;
  }

  // Hàm hiển thị Icon + Tên (dùng logic hiển thị)
  static String getTietKhiIconAndNameString(DateTime date) {
    final info = getTietKhiInfoForDisplay(date);
    final name = info['name'] as String? ?? 'Không xác định';
    final icon = info['icon'] as String? ?? '❓';
    return name;
  }

  // Hàm hiển thị đầy đủ (dùng logic hiển thị)
  static String getTietKhiFullDisplayString(DateTime date) {
    final info = getTietKhiInfoForDisplay(date);
    final name = info['name'] as String? ?? 'Lỗi';
    final icon = info['icon'] as String? ?? '❓';
    final range = info['displayRange'] as String? ?? '(Lỗi)';

    if (name == 'Lỗi' ||
        range == '(Lỗi)' ||
        name == 'Không xác định' ||
        range == '(Ngoài phạm vi)' ||
        range == '(N/A)') {
      return '$name $range';
    }
    return '$name $range';
  }

  // Cache Ngũ hành
  static final Map<String, Map<String, String>> _hanhCache = {};

  // Lấy Ngũ hành Can Chi và Nạp Âm của ngày
  static Map<String, String> getHanhOfDay(DateTime date) {
    final key = '${date.year}-${date.month}-${date.day}';
    if (_hanhCache.containsKey(key)) {
      return _hanhCache[key]!;
    }

    try {
      final canChiDay = getCanChiDay(date.toLocal());
      final parts = canChiDay.split(' ');
      if (parts.length != 2) throw Exception('Invalid Can-Chi format');
      final can = parts[0];
      final chi = parts[1];

      // Ngũ hành Can Chi (dựa trên Thiên Can)
      final canHanh = TimeConstant.canToHanh[can] ?? "Kim";
      final chiHanh = TimeConstant.chiToHanh[chi] ?? "Thủy";

      // Ngũ hành Nạp Âm
      final napAmData = TimeConstant.napAmTable[canChiDay] ??
          {"napAm": "Bích Thượng Thổ", "hanh": "Thổ"};
      final napAm = napAmData["napAm"]!;
      final napAmHanh = napAmData["hanh"]!;

      final result = {
        'canChi': canChiDay,
        'canHanh': canHanh,
        'chiHanh': chiHanh,
        'napAm': napAm,
        'napAmHanh': napAmHanh
      };
      _hanhCache[key] = result;
      return result;
    } catch (e) {
      LoggerUtils.error('Error getting hanh of day', e);
      return {
        'canChi': 'Canh Tý',
        'canHanh': 'Kim',
        'chiHanh': 'Thủy',
        'napAm': 'Bích Thượng Thổ',
        'napAmHanh': 'Thổ'
      };
    }
  }

  static String getNapAmOnly(DateTime date, {bool isDay = true}) {
    try {
      String canChiTarget;
      if (isDay) {
        canChiTarget = getCanChiDay(date.toLocal());
      } else {
        canChiTarget = getCanChiYear(date.toLocal());
      }
      final napAmData = TimeConstant.napAmTable[canChiTarget];
      return napAmData?['napAm'] ?? 'Không xác định'; // Chỉ trả về tên Nạp Âm
    } catch (e) {
      LoggerUtils.error('Lỗi khi lấy tên Nạp Âm', e);
      return 'Lỗi tra cứu';
    }
  }

  static String getNapAmHanh(DateTime date) {
    try {
      final canChi = getCanChiDay(date.toLocal()); // Lấy Can Chi Ngày

      final napAmData = TimeConstant.napAmTable[canChi];

      if (napAmData != null && napAmData['hanh'] != null) {
        return napAmData['hanh']!;
      } else {
        LoggerUtils.error("Không tìm thấy Nạp Âm cho Can Chi: $canChi");
        final can = canChi.split(' ').first;
        return TimeConstant.canToHanh[can] ?? "Kim"; // Mặc định là Kim
      }
    } catch (e) {
      LoggerUtils.error("Lỗi khi lấy Hành Nạp Âm cho ngày $date: $e");
      return "Thổ"; // Mặc định an toàn khi có lỗi
    }
  }

  // Lấy Ngũ hành Can Chi (dùng cho UI)
  static String getHanh(DateTime date) {
    return getHanhOfDay(date)['canHanh']!;
  }

// Cache cho kết quả Nhị Thập Bát Tú
  static final Map<String, Map<String, dynamic>> _nhiThapBatTuCache = {};
// Ngày cơ sở: 09/02/2005 (thứ 4) là sao "Cơ"
  static final DateTime baseDate = DateTime(2005, 2, 9);
  static const int baseStarIndex = 6; // "Cơ" là chỉ số 6 trong danh sách

  // Lấy thông tin sao Nhị Thập Bát Tú theo ngày dương lịch
  static Map<String, dynamic> getNhiThapBatTu(DateTime date) {
    final normalizedDate = DateTime(date.year, date.month, date.day).toLocal();
    final dateKey =
        '${normalizedDate.year}-${normalizedDate.month}-${normalizedDate.day}';

    if (_nhiThapBatTuCache.containsKey(dateKey)) {
      return _nhiThapBatTuCache[dateKey]!;
    }

    try {
      // Tính số ngày chênh lệch từ ngày cơ sở
      int daysDiff = normalizedDate.difference(baseDate).inDays;

      // Tính chỉ số sao
      int saoIndex = (baseStarIndex + daysDiff) % 28;
      if (saoIndex < 0) saoIndex += 28; // Đảm bảo không âm

      final saoInfo = {...TimeConstant.nhiThapBatTu[saoIndex]};
      _nhiThapBatTuCache[dateKey] = saoInfo;

      LoggerUtils.debug(
          'Ngày $normalizedDate, Số ngày từ 09/02/2005: $daysDiff, Sao: ${saoInfo["name"]}');

      limitNhiThapBatTuCacheSize();
      return saoInfo;
    } catch (e) {
      LoggerUtils.error('Error calculating Nhi Thap Bat Tu', e);
      return {
        "name": "Nguy",
        "element": "Nguyệt",
        "nature": "Xấu",
        "description": "Tránh khởi công, chuyển nhà, động thổ"
      };
    }
  }

// Trả về tên sao (tương thích ngược với code cũ)
  static String getSao(DateTime date) {
    return getNhiThapBatTu(date)["name"];
  }

  static String getElementsInfoWithIcons(DateTime date) {
    try {
      // 1. Lấy dữ liệu ngũ hành
      final hanhData = getHanhOfDay(date);
      final hanhKey = hanhData['napAmHanh']?.toLowerCase().trim() ?? 'kim';
      final hanhIcon = TimeConstant.hanhIcons[hanhKey] ?? '🌐';
      final hanhText = hanhData['napAmHanh'] ?? 'Kim';

      // 2. Lấy dữ liệu sao
      final sao = getSao(date).toLowerCase().trim();
      final saoIcon = TimeConstant.saoIcons[sao] ??
          '🌟'; // Icon mặc định nếu không tìm thấy
      final saoText = getSao(date);

      // 3. Lấy dữ liệu trực
      final truc = getTruc(date).toLowerCase().trim();
      final trucIcon = TimeConstant.trucIcons[truc] ??
          '🛠️'; // Icon mặc định nếu không tìm thấy
      final trucText = getTruc(date);

      // 4. Kết hợp icon và text thành chuỗi hoàn chỉnh
      return 'Hành $hanhText | Sao $saoText | Trực $trucText';
    } catch (e) {
      // Giá trị mặc định khi có lỗi
      return '⚒️ Hành Kim | 🌙 Sao Nguy | 🏗️ Trực Kiến';
    }
  }

// Các phương thức bổ sung
  static Map<String, dynamic> getSaoInfo(DateTime date) {
    return getNhiThapBatTu(date);
  }

  static bool isSaoLucky(DateTime date) {
    return getNhiThapBatTu(date)["nature"] == "Tốt";
  }

  static String getSaoElement(DateTime date) {
    return getNhiThapBatTu(date)["element"];
  }

  static String getSaoDescription(DateTime date) {
    return getNhiThapBatTu(date)["description"];
  }

// Kiểm soát kích thước cache
  static void limitNhiThapBatTuCacheSize([int maxSize = 100]) {
    if (_nhiThapBatTuCache.length > maxSize) {
      final keysToRemove = _nhiThapBatTuCache.keys
          .take(_nhiThapBatTuCache.length - maxSize)
          .toList();
      for (final key in keysToRemove) {
        _nhiThapBatTuCache.remove(key);
      }
    }
  }

  // Lấy trực theo ngày
  static String _getKienChi(String tietKhi, int lunarMonth) {
    final kienChi = TimeConstant.tietKhiToKienChi.entries
        .firstWhere(
          (e) => tietKhi.toLowerCase().contains(e.key.toLowerCase()),
          orElse: () => const MapEntry('', ''),
        )
        .value;
    return kienChi.isNotEmpty
        ? kienChi
        : [
            'Dần',
            'Mão',
            'Thìn',
            'Tỵ',
            'Ngọ',
            'Mùi',
            'Thân',
            'Dậu',
            'Tuất',
            'Hợi',
            'Tý',
            'Sửu'
          ][(lunarMonth - 1) % 12];
  }

  static int _getChiIndex(String chi) =>
      const {
        'Tý': 0,
        'Sửu': 1,
        'Dần': 2,
        'Mão': 3,
        'Thìn': 4,
        'Tỵ': 5,
        'Ngọ': 6,
        'Mùi': 7,
        'Thân': 8,
        'Dậu': 9,
        'Tuất': 10,
        'Hợi': 11
      }[chi] ??
      0;

  static String getTruc(DateTime date) {
    try {
      final lunarDate = getSolarToLunar(date.toLocal());
      final chi = getCanChiDay(date.toLocal()).split(' ')[1];
      final tietKhi = getTietKhiName(date);
      final kienChi = _getKienChi(tietKhi, lunarDate.month);
      final trucList = [
        'Kiến',
        'Trừ',
        'Mãn',
        'Bình',
        'Định',
        'Chấp',
        'Phá',
        'Nguy',
        'Thành',
        'Thu',
        'Khai',
        'Bế'
      ];
      final trucIdx = (_getChiIndex(chi) - _getChiIndex(kienChi) + 12) % 12;
      LoggerUtils.debug(
          '[TRUC] Date: $date, Lunar: ${lunarDate.day}/${lunarDate.month}, Chi: $chi, TietKhi: $tietKhi, Truc: ${trucList[trucIdx]}');
      return trucList[trucIdx];
    } catch (e) {
      LoggerUtils.error('[TRUC] Error: $e');
      return "Kiến";
    }
  }

  static final Map<String, int> _lunarMonthDaysCache = {};
  static const int _maxCacheSize = 100; // Giới hạn cache 100 tháng (~3KB)

  static int getDaysInLunarMonth(int year, int month, bool isLeap) {
    final cacheKey = '$year-$month-$isLeap';
    if (_lunarMonthDaysCache.containsKey(cacheKey)) {
      return _lunarMonthDaysCache[cacheKey]!;
    }

    try {
      final lunarStart = LunarDateTime(
        year: year,
        month: month,
        day: 1,
        isLeap: isLeap,
      );
      final solarStart =
          FullCalenderExtension.convertLunarDateToSolarDate(lunarStart);
      if (solarStart == null) throw Exception('Invalid lunar date');

      final fullCalender = FullCalender(
        date: solarStart,
        timeZone: TimeZone.vietnamese.timezone,
      );
      final jdStart = fullCalender.julianDay;

      // Tính k ban đầu
      const double juliusDaysIn1900 = 2415021.076998695;
      const double newMoonCycle = 29.530588853;
      int k = ((jdStart - juliusDaysIn1900) / newMoonCycle).floor();

      // Tìm newMoonStart gần nhất với jdStart
      int newMoonStart =
          fullCalender.getNewMoonDay(k, TimeZone.vietnamese.timezone);
      int newMoonStartMinus =
          fullCalender.getNewMoonDay(k - 1, TimeZone.vietnamese.timezone);
      int newMoonStartPlus =
          fullCalender.getNewMoonDay(k + 1, TimeZone.vietnamese.timezone);

      // Chọn k sao cho newMoonStart gần jdStart nhất
      if ((newMoonStartMinus - jdStart).abs() <
          (newMoonStart - jdStart).abs()) {
        k = k - 1;
        newMoonStart = newMoonStartMinus;
      } else if ((newMoonStartPlus - jdStart).abs() <
          (newMoonStart - jdStart).abs()) {
        k = k + 1;
        newMoonStart = newMoonStartPlus;
      }

      // Tính newMoonNext
      int newMoonNext =
          fullCalender.getNewMoonDay(k + 1, TimeZone.vietnamese.timezone);

      final days = newMoonNext - newMoonStart;
      if (_lunarMonthDaysCache.length >= _maxCacheSize) {
        _lunarMonthDaysCache.remove(_lunarMonthDaysCache.keys.first);
      }
      _lunarMonthDaysCache[cacheKey] = days;
      return days;
    } catch (e) {
      LoggerUtils.error('Error calculating days in lunar month', e);
      return 29; // Giá trị mặc định an toàn
    }
  }

  // Tính số ngày trong tháng âm lịch từ ngày dương lịch
  static int getDaysInLunarMonthFromDate(DateTime date) {
    final lunarDate = getSolarToLunar(date.toLocal());
    return getDaysInLunarMonth(
        lunarDate.year, lunarDate.month, lunarDate.isLeap);
  }

  // Lấy thông tin chi tiết về tháng âm lịch
  static Map<String, dynamic> getLunarMonthDetails(DateTime date) {
    final lunarDate = getSolarToLunar(date.toLocal());
    final days =
        getDaysInLunarMonth(lunarDate.year, lunarDate.month, lunarDate.isLeap);
    final status = days == 30 ? "(đủ)" : "(thiếu)";
    final display = lunarDate.isLeap ? "nhuận $status" : status;

    return {
      'year': lunarDate.year,
      'month': lunarDate.month,
      'isLeap': lunarDate.isLeap,
      'days': days,
      'status': status,
      'display': display,
    };
  }

  /// Kiểm tra một ngày có phải là ngày mùng 1 của tháng nhuận không.
  /// Hàm này hiệu quả hơn vì chỉ cần một lần chuyển đổi sang âm lịch.
  static bool isFirstDayOfLeapMonth(DateTime date) {
    try {
      // Lấy thông tin âm lịch của ngày đang xét (tận dụng cache)
      final lunarDate = getSolarToLunar(date.toLocal());

      // Trả về true NẾU (ngày là mùng 1) VÀ (tháng là tháng nhuận)
      return (lunarDate.day == 1 || lunarDate.day == 15) && lunarDate.isLeap;
    } catch (e) {
      LoggerUtils.error('Error checking for first day of leap month', e);
      return false;
    }
  }

  // Tính trước số ngày cho các tháng trong một năm
  static void precomputeLunarMonths(int year) {
    for (int month = 1; month <= 12; month++) {
      // Tính cho tháng thường
      final daysNormal = getDaysInLunarMonth(year, month, false);
      final cacheKeyNormal = '$year-$month-false';
      _lunarMonthDaysCache[cacheKeyNormal] = daysNormal;

      // Kiểm tra và tính cho tháng nhuận nếu có
      final lunarStart =
          LunarDateTime(year: year, month: month, day: 1, isLeap: true);
      final solarStart =
          FullCalenderExtension.convertLunarDateToSolarDate(lunarStart);
      if (solarStart != null) {
        final fullCalender = FullCalender(
          date: solarStart,
          timeZone: TimeZone.vietnamese.timezone,
        );
        final lunarCheck = fullCalender.lunarDate;
        if (lunarCheck.isLeap && lunarCheck.month == month) {
          final daysLeap = getDaysInLunarMonth(year, month, true);
          final cacheKeyLeap = '$year-$month-true';
          _lunarMonthDaysCache[cacheKeyLeap] = daysLeap;
        }
      }
    }
    limitCacheSize(); // Sử dụng giá trị mặc định _maxCacheSize
  }

  // Lấy thông tin tháng âm lịch (trực quan)
  static String getLunarMonthType(DateTime date) {
    try {
      final details = getLunarMonthDetails(date);
      return details['display'];
    } catch (e) {
      LoggerUtils.error('Error getting lunar month type', e);
      return "(đủ)";
    }
  }

  // Kiểm tra tháng nhuận
  static bool isLeapMonth(DateTime date) {
    try {
      return getSolarToLunar(date.toLocal()).isLeap;
    } catch (e) {
      LoggerUtils.error('Error checking if month is leap month', e);
      return false;
    }
  }

  // Phương thức lấy thông tin Ngọc Hạp Thông Thư
  static String getNgocHapInfo(DateTime date) {
    return NgocHapServiceExtension.formatNgocHapResult(date);
  }

// Phương thức lấy danh sách sao tốt
  static List<Map<String, String>> getNgocHapCatTinh(DateTime date) {
    return NgocHapServiceExtension.getCatTinh(date);
  }

// Phương thức lấy danh sách sao xấu
  static List<Map<String, String>> getNgocHapHungSat(DateTime date) {
    return NgocHapServiceExtension.getHungSat(date);
  }

  static String getZodiacSign(DateTime date) {
    final localDate = date.toLocal();
    final key = '${localDate.month}-${localDate.day}';

    // Cache để lưu kết quả đã tính
    final Map<String, String> zodiacCache = {};

    if (zodiacCache.containsKey(key)) {
      return zodiacCache[key]!;
    }

    try {
      final month = localDate.month;
      final day = localDate.day;
      String zodiacSign;

      if ((month == 3 && day >= 21) || (month == 4 && day <= 19)) {
        zodiacSign = 'Bạch Dương';
      } else if ((month == 4 && day >= 20) || (month == 5 && day <= 20)) {
        zodiacSign = 'Kim Ngưu';
      } else if ((month == 5 && day >= 21) || (month == 6 && day <= 20)) {
        zodiacSign = 'Song Tử';
      } else if ((month == 6 && day >= 21) || (month == 7 && day <= 22)) {
        zodiacSign = 'Cự Giải';
      } else if ((month == 7 && day >= 23) || (month == 8 && day <= 22)) {
        zodiacSign = 'Sư Tử';
      } else if ((month == 8 && day >= 23) || (month == 9 && day <= 22)) {
        zodiacSign = 'Xử Nữ';
      } else if ((month == 9 && day >= 23) || (month == 10 && day <= 22)) {
        zodiacSign = 'Thiên Bình';
      } else if ((month == 10 && day >= 23) || (month == 11 && day <= 21)) {
        zodiacSign =
            'Bọ Cạp'; // Sửa "Thiên Yết" thành "Bọ Cạp" cho đúng tên chuẩn
      } else if ((month == 11 && day >= 22) || (month == 12 && day <= 21)) {
        zodiacSign = 'Nhân Mã';
      } else if ((month == 12 && day >= 22) || (month == 1 && day <= 19)) {
        zodiacSign = 'Ma Kết';
      } else if ((month == 1 && day >= 20) || (month == 2 && day <= 18)) {
        zodiacSign = 'Bảo Bình';
      } else if ((month == 2 && day >= 19) || (month == 3 && day <= 20)) {
        zodiacSign = 'Song Ngư';
      } else {
        zodiacSign =
            'Bạch Dương'; // Mặc định trả về Bạch Dương thay vì "Không xác định"
      }

      zodiacCache[key] = zodiacSign;
      return zodiacSign;
    } catch (e) {
      LoggerUtils.error('Error determining zodiac sign', e);
      const defaultSign = 'Không xác định';
      zodiacCache[key] = defaultSign;
      return defaultSign;
    }
  }

  static bool _isTamNuong(LunarDateTime lunarDate) {
    return TimeConstant.tamNuongDays.contains(lunarDate.day);
  }

  static bool _isNguyetKy(LunarDateTime lunarDate) {
    return TimeConstant.nguyetKyDays.contains(lunarDate.day);
  }

  static bool _isNguyetTan(LunarDateTime lunarDate) {
    try {
      // Cần gọi hàm tính số ngày trong tháng âm lịch
      final daysInMonth = LunarService.getDaysInLunarMonth(
          lunarDate.year, lunarDate.month, lunarDate.isLeap);
      return lunarDate.day == daysInMonth;
    } catch (e) {
      LoggerUtils.error("Lỗi kiểm tra Nguyệt Tận: $e");
      return false; // Mặc định không phải nếu lỗi
    }
  }

  static bool _isDuongCongKyNhat(LunarDateTime lunarDate) {
    final List<int>? tabooDays = TimeConstant.duongCongKyNhat[lunarDate.month];
    return tabooDays != null && tabooDays.contains(lunarDate.day);
  }

  static bool _isSatChuAm(LunarDateTime lunarDate, String chiDay) {
    final String? tabooChi = TimeConstant.satChuAm[lunarDate.month];
    return tabooChi != null && chiDay == tabooChi;
  }

  static bool _isSatChuDuong(LunarDateTime lunarDate, String chiDay) {
    // Xử lý các tháng có cùng chi kỵ
    final Map<int, List<int>> monthGroups = {
      2: [2, 3, 7, 9], // Các tháng kỵ Sửu
      5: [5, 6, 8, 10, 12], // Các tháng kỵ Thìn
    };

    if (monthGroups[2]!.contains(lunarDate.month)) {
      return chiDay == "Sửu";
    }
    if (monthGroups[5]!.contains(lunarDate.month)) {
      return chiDay == "Thìn";
    }

    // Xử lý các tháng còn lại
    final String? tabooChi = TimeConstant.satChuDuong[lunarDate.month];
    return tabooChi != null && chiDay == tabooChi;
  }

  static bool _isKimThanThatSat(String canYear, String chiDay) {
    final List<String>? tabooChis = TimeConstant.kimThanThatSat[canYear];
    return tabooChis != null && tabooChis.contains(chiDay);
  }

  static bool _isTrungPhuc(LunarDateTime lunarDate, String canDay) {
    final String? tabooCan = TimeConstant.trungPhuc[lunarDate.month];
    return tabooCan != null && canDay == tabooCan;
  }

  static bool _isThuTu(LunarDateTime lunarDate, String chiDay) {
    final String? tabooChi = TimeConstant.thuTu[lunarDate.month];
    return tabooChi != null && chiDay == tabooChi;
  }

  // ----- Hàm public lấy danh sách ngày kỵ áp dụng -----
  static List<Map<String, String>> getApplicableTabooDays(DateTime date) {
    final List<Map<String, String>> applicableTaboos = [];
    try {
      final lunarDate = LunarService.getSolarToLunar(date.toLocal());
      final canChiDay = LunarService.getCanChiDay(date);
      final canChiYear = LunarService.getCanChiYear(date);

      final partsDay = canChiDay.split(' ');
      final partsYear = canChiYear.split(' ');

      if (partsDay.length != 2 || partsYear.isEmpty) {
        throw Exception('Lỗi lấy Can Chi Ngày hoặc Năm');
      }
      final canDay = partsDay[0];
      final chiDay = partsDay[1];
      final canYear = partsYear[0];

      if (_isTamNuong(lunarDate)) {
        applicableTaboos.add({
          'name': 'Tam Nương',
          'description': TimeConstant.tabooDayDescriptions['Tam Nương']!
        });
      }
      if (_isNguyetKy(lunarDate)) {
        applicableTaboos.add({
          'name': 'Nguyệt Kỵ',
          'description': TimeConstant.tabooDayDescriptions['Nguyệt Kỵ']!
        });
      }
      if (_isNguyetTan(lunarDate)) {
        applicableTaboos.add({
          'name': 'Nguyệt Tận',
          'description': TimeConstant.tabooDayDescriptions['Nguyệt Tận']!
        });
      }
      if (_isDuongCongKyNhat(lunarDate)) {
        applicableTaboos.add({
          'name': 'Dương Công Kỵ Nhật',
          'description':
              TimeConstant.tabooDayDescriptions['Dương Công Kỵ Nhật']!
        });
      }
      if (_isSatChuAm(lunarDate, chiDay)) {
        applicableTaboos.add({
          'name': 'Sát Chủ Âm',
          'description': TimeConstant.tabooDayDescriptions['Sát Chủ Âm']!
        });
      }
      if (_isSatChuDuong(lunarDate, chiDay)) {
        applicableTaboos.add({
          'name': 'Sát Chủ Dương',
          'description': TimeConstant.tabooDayDescriptions['Sát Chủ Dương']!
        });
      }
      if (_isKimThanThatSat(canYear, chiDay)) {
        applicableTaboos.add({
          'name': 'Kim Thần Thất Sát',
          'description': TimeConstant.tabooDayDescriptions['Kim Thần Thất Sát']!
        });
      }
      if (_isTrungPhuc(lunarDate, canDay)) {
        applicableTaboos.add({
          'name': 'Trùng Phục',
          'description': TimeConstant.tabooDayDescriptions['Trùng Phục']!
        });
      }
      if (_isThuTu(lunarDate, chiDay)) {
        applicableTaboos.add({
          'name': 'Thụ Tử',
          'description': TimeConstant.tabooDayDescriptions['Thụ Tử']!
        });
      }
    } catch (e, s) {
      LoggerUtils.error("Lỗi khi lấy danh sách ngày kỵ", e, s);
    }
    return applicableTaboos;
  }

  // ----- Hàm public lấy thông tin Bành Tổ Bách Kỵ -----
  static Map<String, String> getBanhToTaboos(DateTime date) {
    try {
      final canChiDay = LunarService.getCanChiDay(date);
      final parts = canChiDay.split(' ');
      if (parts.length != 2) {
        throw Exception('Lỗi lấy Can Chi Ngày cho Bành Tổ');
      }
      final can = parts[0];
      final chi = parts[1];

      return {
        "can": TimeConstant.banhToCanTaboos[can] ?? "Không có kỵ nhật Can này.",
        "chi": TimeConstant.banhToChiTaboos[chi] ?? "Không có kỵ nhật Chi này.",
      };
    } catch (e, s) {
      LoggerUtils.error("Lỗi khi lấy Bành Tổ Bách Kỵ", e, s);
      return {"can": "Lỗi tra cứu", "chi": "Lỗi tra cứu"};
    }
  }

  // --- PHẦN THÊM MỚI ĐỂ TÍNH GIỜ CAN CHI ---
  // --- PHẦN THÊM MỚI ĐỂ TÍNH GIỜ CAN CHI (SỬA ĐỔI) ---
  static String getCanChiGioFromSolarWithIcon(
      DateTime solarDate, int hour, String dayCan) {
    if (dayCan.isEmpty) {
      try {
        final canChiNgay = getCanChiDay(solarDate.toLocal()); // Không có icon
        final parts = canChiNgay.split(' ');
        if (parts.isNotEmpty) {
          dayCan = parts[0];
          if (!TimeConstant.hangCan.contains(dayCan)) {
            return "${TimeConstant.defaultChiIconPath} Can Ngày không hợp lệ"; // Thêm icon lỗi
          }
        } else {
          return "${TimeConstant.defaultChiIconPath} Không rõ Can Ngày";
        }
      } catch (_) {
        return "${TimeConstant.defaultChiIconPath} Lỗi Can Ngày";
      }
    } else if (!TimeConstant.hangCan.contains(dayCan)) {
      return "${TimeConstant.defaultChiIconPath} Can Ngày không hợp lệ";
    }

    int hourIndex = ((hour + 1) ~/ 2) % 12;
    if (hourIndex < 0 || hourIndex >= TimeConstant.hangChi.length) {
      return "${TimeConstant.defaultChiIconPath} Lỗi Chi Giờ";
    }
    String currentChi = TimeConstant.hangChi[hourIndex];
    String chiIconPath = getChiIcon(currentChi); // Lấy Icon Path ở đây

    int dayCanIndex = TimeConstant.hangCan.indexOf(dayCan);
    int startCanIndex;
    switch (dayCanIndex % 5) {
      case 0:
        startCanIndex = 0;
        break;
      case 1:
        startCanIndex = 2;
        break;
      case 2:
        startCanIndex = 4;
        break;
      case 3:
        startCanIndex = 6;
        break;
      case 4:
        startCanIndex = 8;
        break;
      default:
        return "${TimeConstant.defaultChiIconPath} Lỗi tính Can Giờ";
    }

    int currentCanIndex = (startCanIndex + hourIndex) % 10;
    if (currentCanIndex < 0 || currentCanIndex >= TimeConstant.hangCan.length) {
      return "${TimeConstant.defaultChiIconPath} Lỗi Can Giờ";
    }
    String currentCan = TimeConstant.hangCan[currentCanIndex];

    // Ghép chuỗi kết quả bao gồm cả icon path
    return "$chiIconPath Giờ $currentCan $currentChi";
  }

  static String getCurrentCanChiGioWithIcon(
      DateTime solarDate, DateTime currentTime) {
    // Gọi hàm chính, truyền dayCan rỗng để nó tự lấy
    return getCanChiGioFromSolarWithIcon(
        solarDate.toLocal(), currentTime.toLocal().hour, "");
  }

  static List<Map<String, dynamic>> getDetailedGioHoangDao(DateTime date) {
    final results = <Map<String, dynamic>>[];
    final String dayCanChi = getCanChiDay(date); // Hàm này không trả về icon
    final String dayCan = dayCanChi.split(' ')[0];
    final String dayChi = dayCanChi.split(' ')[1];
    final Map<String, String> dayNapAmData = getHanhOfDay(date);
    final String dayHanh = dayNapAmData['napAmHanh']!;
    final List<String> luckyHourNames = getGioHoangDao(
        date); // Danh sách tên Chi của giờ Hoàng đạo (vd: 'tý', 'sửu')

    for (final gioNameInChi in luckyHourNames) {
      // gioNameInChi bây giờ là tên Chi, vd: 'tý'
      try {
        // Từ gioNameInChi, chúng ta lấy thông tin đầy đủ của giờ đó
        final String hourNameCapitalized =
            "${gioNameInChi[0].toUpperCase()}${gioNameInChi.substring(1)}"; // Vd: "Tý"
        final String standardRange = TimeConstant.khungGio[gioNameInChi] ??
            "(?:??-??:??)"; // Khung giờ chuẩn
        final String formattedTimeRange =
            _formatHourRangeForDisplay(standardRange); // Format hiển thị
        final int startHour =
            _getStartHourFromRange(standardRange); // Giờ bắt đầu

        // Tính Can Chi của Giờ (không có icon)
        final String canChiGioString =
            _getCanChiGioString(startHour, dayCan); // Vd: "Giáp Tý"
        final String hourChi = canChiGioString.split(' ')[1]; // Vd: "Tý"
        final String hourCan = canChiGioString.split(' ')[0]; // Vd: "Giáp"

        final Map<String, String> hourNapAmData =
            TimeConstant.napAmTable[canChiGioString] ?? {"hanh": "Không rõ"};
        final String menhGio = hourNapAmData['hanh']!;
        final String canChiMenhCombined = "$canChiGioString\nHành $menhGio";

        final Map<String, dynamic> typeAndRating = _determineHourTypeAndRating(
            hourCan, hourChi, menhGio, dayCan, dayChi, dayHanh);

        // --- THAY ĐỔI Ở ĐÂY: Lấy đường dẫn ảnh thay vì ký tự Unicode ---
        final String zodiacIconPath =
            TimeConstant.chiIcons[hourChi] ?? TimeConstant.defaultChiIconPath;
        // --------------------------------------------------------------

        final Map<String, Color> zodiacColors =
            TimeConstant.chiColors[hourChi] ??
                TimeConstant.chiColors['default']!;
        final Color zodiacBackgroundColor = zodiacColors['background']!;
        final Color zodiacBorderColor = zodiacColors['border']!;

        results.add({
          'name': hourNameCapitalized, // Tên giờ (vd: "Tý")
          'timeRange': formattedTimeRange, // Khung giờ hiển thị (vd: "23h-1h")
          'canChiMenh': canChiMenhCombined, // Can Chi và Mệnh của giờ
          'type': typeAndRating['type'], // Loại giờ (Tốt, Trung bình, Kỳ)
          'rating': typeAndRating['rating'], // Đánh giá (số sao)
          'zodiacSign': hourChi, // Tên Chi của giờ (vd: "Tý")
          'zodiacIconPath':
              zodiacIconPath, // <<< SỬA THÀNH PATH >>> Đường dẫn icon
          'zodiacBackgroundColor': zodiacBackgroundColor, // Màu nền icon
          'zodiacBorderColor': zodiacBorderColor, // Màu viền icon
        });
      } catch (e, s) {
        LoggerUtils.error(
            "Lỗi khi xử lý chi tiết giờ hoàng đạo '$gioNameInChi' cho ngày $date",
            e,
            s);
      }
    }

    // Sắp xếp kết quả (logic không đổi)
    results.sort((a, b) {
      final timeA = a['timeRange'] as String;
      final timeB = b['timeRange'] as String;
      final startHourA =
          int.tryParse(timeA.split('h')[0]) ?? 0; // Lấy số giờ đầu
      final startHourB = int.tryParse(timeB.split('h')[0]) ?? 0;
      // Xử lý trường hợp 23h là giờ Tý, cần đứng đầu
      final adjustedHourA = startHourA == 23 ? -1 : startHourA;
      final adjustedHourB = startHourB == 23 ? -1 : startHourB;
      return adjustedHourA.compareTo(adjustedHourB);
    });

    return results;
  }

  /// Helper: Xác định loại và rating cho giờ dựa trên tương tác với Ngày
  /// (Logic này có thể cần tinh chỉnh thêm cho phù hợp với yêu cầu cụ thể)
  static Map<String, dynamic> _determineHourTypeAndRating(
      String hourCan,
      String hourChi,
      String hourHanh,
      String dayCan,
      String dayChi,
      String dayHanh) {
    String type = "Tốt"; // Mặc định cho giờ Hoàng đạo
    int rating = 4; // Mặc định 4 sao cho giờ Hoàng đạo

    // 1. Ưu tiên quan hệ Lục Hợp / Tam Hợp (Rất Tốt)d
    if (ChiRelationService.isLucHop(hourChi, dayChi) ||
        ChiRelationService.isTamHop(hourChi, dayChi)) {
      type = "Tốt";
      rating = 5;
      return {'type': type, 'rating': rating}; // Trả về luôn nếu Hợp
    }

    // 2. Xét quan hệ Xung/Hại/Phá/Hình (Giảm độ tốt)
    if (ChiRelationService.isLucXung(hourChi, dayChi)) {
      type = "Kỳ";
      rating = 1;
    } else if (ChiRelationService.isTuongHai(hourChi, dayChi)) {
      type = "Kỳ"; // Hoặc "Trung bình" tùy mức độ bạn muốn
      rating = 2;
    } else if (ChiRelationService.isTuongPha(hourChi, dayChi) ||
        ChiRelationService.isTuongHinh(hourChi, dayChi)) {
      type = "Trung bình";
      rating = 2;
    } else if (ChiRelationService.isTuHinh(hourChi) && hourChi == dayChi) {
      // Tự hình trùng chi ngày
      type = "Trung bình";
      rating = 2;
    }

    // 3. Xét quan hệ Ngũ Hành Nạp Âm (Điều chỉnh thêm nếu không Xung/Hại/Phá/Hình nặng)
    if (type != "Kỳ") {
      // Chỉ xét ngũ hành nếu giờ không quá xấu do Xung/Hại
      if (NguHanhRelationService.isSinh(dayHanh, hourHanh)) {
        // Ngày sinh Giờ
        // Giữ nguyên hoặc tăng nhẹ nếu đang là Tốt/Trung Bình
        if (rating < 5) rating++;
        type = "Tốt";
      } else if (NguHanhRelationService.isSinh(hourHanh, dayHanh)) {
        // Giờ sinh Ngày
        // Giữ nguyên Tốt/Trung bình
        type = "Tốt";
      } else if (NguHanhRelationService.isKhac(dayHanh, hourHanh)) {
        // Ngày khắc Giờ
        if (rating > 1) rating--; // Giảm điểm
        if (rating <= 2) type = "Trung bình";
      } else if (NguHanhRelationService.isKhac(hourHanh, dayHanh)) {
        // Giờ khắc Ngày
        if (rating > 1)
          rating = (rating - 2).clamp(1, 5); // Giảm điểm nhiều hơn
        if (rating <= 1)
          type = "Kỳ";
        else if (rating <= 2) type = "Trung bình";
      } else if (hourHanh == dayHanh) {
        // Đồng hành
        // Giữ nguyên hoặc tăng nhẹ
        if (rating < 5 && type == "Tốt") rating++;
        type = "Tốt";
      }
    }

    // 4. (Tùy chọn) Xét thêm quan hệ Can Giờ - Can Ngày (ít ảnh hưởng hơn)
    // Ví dụ: Can Hợp -> Tăng nhẹ điểm, Can Xung -> Giảm nhẹ điểm

    // Đảm bảo rating cuối cùng trong khoảng 1-5
    rating = rating.clamp(1, 5);

    // Cập nhật lại Type dựa trên rating cuối cùng nếu cần
    if (rating >= 4)
      type = "Tốt";
    else if (rating >= 2)
      type = "Trung bình";
    else
      type = "Kỳ";

    return {'type': type, 'rating': rating};
  }

  /// Helper: Định dạng lại khung giờ "(HH:mm-HH:mm)" thành "(Xh-Yh)"
  /// ĐÃ SỬA LỖI PARSING
  static String _formatHourRangeForDisplay(String standardRange) {
    try {
      // 1. Trích xuất phần thời gian bên trong dấu ngoặc đơn
      final timeMatch = RegExp(r'\((\d{1,2}:\d{2}-\d{1,2}:\d{2})\)')
          .firstMatch(standardRange);
      if (timeMatch == null || timeMatch.groupCount < 1) {
        LoggerUtils.warning(
            "Không thể trích xuất time range từ: '$standardRange'");
        // Trả về định dạng gốc hoặc một chuỗi lỗi rõ ràng hơn
        return standardRange.replaceAll(
            RegExp(r'[()]'), ''); // Bỏ ngoặc nếu không parse được
      }
      final timePart =
          timeMatch.group(1)!; // Ví dụ: "23:00-0:59" hoặc "1:00-2:59"

      // 2. Tách giờ bắt đầu và kết thúc từ phần đã trích xuất
      final parts =
          timePart.split('-'); // ["23:00", "0:59"] hoặc ["1:00", "2:59"]
      if (parts.length != 2) return "(Lỗi giờ)";

      // 3. Tách lấy phần giờ (HH)
      final startHourString = parts[0].split(':')[0]; // "23" hoặc "1"
      final endHourString = parts[1].split(':')[0]; // "0" hoặc "2"

      final startHour = int.tryParse(startHourString);
      int? endHourRaw = int.tryParse(endHourString); // Giờ kết thúc gốc

      if (startHour == null || endHourRaw == null) return "(Lỗi giờ)";

      // 4. Xác định giờ kết thúc hiển thị (ví dụ: 1h, 3h, 5h...)
      int endHourDisplay;
      if (startHour == 23 && endHourRaw == 0) {
        endHourDisplay = 1; // Giờ Tý (23h-1h)
      } else {
        // Các giờ khác thường cách nhau 2 tiếng, giờ kết thúc là giờ bắt đầu + 2
        // nhưng hiển thị theo mốc giờ lẻ (1, 3, 5, ...)
        // Ví dụ: 1:00-2:59 -> hiển thị 3h
        // Ví dụ: 3:00-4:59 -> hiển thị 5h
        // Ta có thể lấy giờ bắt đầu + 2 rồi làm tròn xuống giờ lẻ gần nhất nếu cần,
        // Hoặc đơn giản là + 2 (vì các mốc 1, 3, 5... đã là +2 từ 23, 1, 3...)
        endHourDisplay = (startHour + 2) % 24;
        // Đặc biệt xử lý trường hợp 21h-23h
        if (startHour == 21) endHourDisplay = 23;
        // Xử lý trường hợp 23h nếu tính toán ra 1 (đã xử lý ở trên)
        if (endHourDisplay == 1 && startHour != 23)
          endHourDisplay = 25; // Tạm để phân biệt, sẽ % 24 sau
        // Xử lý trường hợp 1h nếu tính toán ra 3
        // ... các trường hợp khác nếu cần

        // Cách đơn giản hơn: dựa vào startHour để xác định endHourDisplay
        switch (startHour) {
          case 23:
            endHourDisplay = 1;
            break;
          case 1:
            endHourDisplay = 3;
            break;
          case 3:
            endHourDisplay = 5;
            break;
          case 5:
            endHourDisplay = 7;
            break;
          case 7:
            endHourDisplay = 9;
            break;
          case 9:
            endHourDisplay = 11;
            break;
          case 11:
            endHourDisplay = 13;
            break;
          case 13:
            endHourDisplay = 15;
            break;
          case 15:
            endHourDisplay = 17;
            break;
          case 17:
            endHourDisplay = 19;
            break;
          case 19:
            endHourDisplay = 21;
            break;
          case 21:
            endHourDisplay = 23;
            break;
          default:
            endHourDisplay = (startHour + 2) % 24; // Dự phòng
        }
      }

      return '${startHour}h-${endHourDisplay}h';
    } catch (e, s) {
      LoggerUtils.error("Lỗi định dạng khung giờ: '$standardRange'", e, s);
      return "(Lỗi)"; // Trả về lỗi nếu có exception
    }
  }

  /// Helper: Lấy giờ bắt đầu từ chuỗi khung giờ chuẩn
  /// ĐÃ SỬA LỖI PARSING
  static int _getStartHourFromRange(String standardRange) {
    try {
      // 1. Trích xuất phần thời gian bên trong dấu ngoặc đơn
      final timeMatch = RegExp(r'\((\d{1,2}:\d{2})-\d{1,2}:\d{2}\)')
          .firstMatch(standardRange);
      if (timeMatch == null || timeMatch.groupCount < 1) {
        LoggerUtils.warning(
            "Không thể trích xuất giờ bắt đầu từ: '$standardRange'");
        return 0; // Default
      }
      // 2. Lấy phần giờ bắt đầu (HH:mm)
      final startTimePart =
          timeMatch.group(1)!.split('-')[0]; // "23:00" hoặc "1:00"
      // 3. Tách lấy phần giờ (HH)
      final hourString = startTimePart.split(':')[0]; // "23" hoặc "1"
      return int.parse(hourString);
    } catch (e, s) {
      LoggerUtils.error("Lỗi lấy giờ bắt đầu từ: '$standardRange'", e, s);
      return 0; // Default on error
    }
  }

  static String _getCanChiGioString(int startHour, String dayCan) {
    // ... (Giữ nguyên code) ...
    int hourIndex = ((startHour + 1) ~/ 2) % 12;
    if (hourIndex < 0 || hourIndex >= TimeConstant.hangChi.length) {
      throw Exception("Lỗi Chi Giờ (Hour Index: $hourIndex)");
    }
    String currentChi = TimeConstant.hangChi[hourIndex];

    int dayCanIndex = TimeConstant.hangCan.indexOf(dayCan);
    if (dayCanIndex == -1) {
      throw Exception("Can Ngày không hợp lệ: $dayCan");
    }

    int startCanIndex;
    switch (dayCanIndex % 5) {
      case 0:
        startCanIndex = 0;
        break; // Giáp, Kỷ
      case 1:
        startCanIndex = 2;
        break; // Ất, Canh
      case 2:
        startCanIndex = 4;
        break; // Bính, Tân
      case 3:
        startCanIndex = 6;
        break; // Đinh, Nhâm
      case 4:
        startCanIndex = 8;
        break; // Mậu, Quý
      default:
        throw Exception("Lỗi không xác định khi tính Can Giờ");
    }

    int currentCanIndex = (startCanIndex + hourIndex) % 10;
    if (currentCanIndex < 0 || currentCanIndex >= TimeConstant.hangCan.length) {
      throw Exception("Lỗi Can Giờ (Can Index: $currentCanIndex)");
    }
    String currentCan = TimeConstant.hangCan[currentCanIndex];

    return "$currentCan $currentChi";
  }

//hàm tính toán vận khí ngày với tháng
  static Map<String, dynamic> calculateNoiKhi(DateTime date) {
    try {
      final canChiDay = LunarService.getCanChiDay(date);
      final parts = canChiDay.split(' ');
      if (parts.length != 2) {
        return {'score': 0.0, 'description': 'Lỗi Can Chi', 'type': 'Lỗi'};
      }
      final can = parts[0];
      final chi = parts[1];
      final canHanh = TimeConstant.canToHanh[can] ?? 'N/A';
      final chiHanh = TimeConstant.chiToHanh[chi] ?? 'N/A';

      if (canHanh == 'N/A' || chiHanh == 'N/A') {
        return {'score': 0.0, 'description': 'Lỗi Hành Can/Chi', 'type': 'Lỗi'};
      }

      String relationKey;
      String relationDesc;

      if (canHanh == chiHanh) {
        relationKey = "Đồng hành";
        relationDesc =
            "Can và Chi cùng hành ($canHanh) – nội khí hài hòa vượng";
      } else if (NguHanhRelationService.isSinh(chiHanh, canHanh)) {
        relationKey = "Chi sinh Can";
        relationDesc =
            "Chi ($chiHanh) sinh Can ($canHanh) – nội khí hài hòa, trợ khí";
      } else if (NguHanhRelationService.isSinh(canHanh, chiHanh)) {
        relationKey = "Can sinh Chi";
        relationDesc =
            "Can ($canHanh) sinh Chi ($chiHanh) – nội khí thuận, khí thông";
      } else if (NguHanhRelationService.isKhac(chiHanh, canHanh)) {
        relationKey = "Chi khắc Can";
        relationDesc =
            "Chi ($chiHanh) khắc Can ($canHanh) – nội khí yếu, dễ bất an";
      } else if (NguHanhRelationService.isKhac(canHanh, chiHanh)) {
        relationKey = "Can khắc Chi";
        relationDesc =
            "Can ($canHanh) khắc Chi ($chiHanh) – nội khí nghịch, dễ xung";
      } else {
        relationKey =
            "Không xác định"; // Trường hợp không thể xảy ra nếu logic đúng
        relationDesc = "Quan hệ Can-Chi không xác định";
      }

      final scoreData = TimeConstant.noiKhiScores[relationKey];
      return {
        'score': scoreData?['score'] ?? 0.0,
        'description': relationDesc,
        'type': scoreData?['rating'] ?? 'Trung bình' // Dùng rating từ bảng điểm
      };
    } catch (e, s) {
      LoggerUtils.error("Lỗi tính Nội Khí", e, s);
      return {
        'score': 0.0,
        'description': 'Lỗi tính toán Nội Khí',
        'type': 'Lỗi'
      };
    }
  }

  // --- Thêm hàm mới getDetailedKhiThangInfo ---
  static Map<String, String> getDetailedKhiThangInfo(DateTime date) {
    try {
      final canChiDay = LunarService.getCanChiDay(date);
      final canChiMonth = LunarService.getCanChiMonth(date);
      final dayParts = canChiDay.split(' ');
      final monthParts = canChiMonth.split(' ');

      if (dayParts.length != 2 || monthParts.length != 2) {
        return {
          'analysis': 'Lỗi xác định Can Chi ngày/tháng.',
          'conclusion': 'Lỗi'
        };
      }

      final dayCan = dayParts[0];
      final dayChi = dayParts[1];
      final monthCan = monthParts[0];
      final monthChi = monthParts[1];

      final dayCanHanh = TimeConstant.canToHanh[dayCan] ?? 'N/A';
      final dayChiHanh = TimeConstant.chiToHanh[dayChi] ?? 'N/A';
      final monthCanHanh = TimeConstant.canToHanh[monthCan] ?? 'N/A';
      final monthChiHanh = TimeConstant.chiToHanh[monthChi] ?? 'N/A';

      final analysisBuffer = StringBuffer();
      double totalScore = 0;

      // Phân tích Can - Can
      String canRelationDesc =
          '• Can ngày $dayCan ($dayCanHanh), Can tháng $monthCan ($monthCanHanh) → ';
      String canRelationKey = "Trung tính";
      if (dayCanHanh != 'N/A' && monthCanHanh != 'N/A') {
        if (NguHanhRelationService.isSinh(monthCanHanh, dayCanHanh)) {
          canRelationKey = "Tháng sinh Ngày";
          canRelationDesc +=
              'Can tháng sinh Can ngày: Dẫn khí tháng nâng đỡ ngày – tốt.';
        } else if (monthCanHanh == dayCanHanh) {
          canRelationKey = "Đồng hành";
          canRelationDesc +=
              'Can tháng đồng hành Can ngày: Cùng hành, hỗ trợ hòa khí.';
        } else if (NguHanhRelationService.isSinh(dayCanHanh, monthCanHanh)) {
          canRelationKey = "Ngày sinh Tháng";
          canRelationDesc +=
              'Can ngày sinh Can tháng: Ngày hao khí để sinh tháng – chấp nhận được.';
        } else if (NguHanhRelationService.isKhac(monthCanHanh, dayCanHanh)) {
          canRelationKey = "Tháng khắc Ngày";
          canRelationDesc +=
              'Can tháng khắc Can ngày: Khí tháng ép Can ngày – ảnh hưởng nhẹ.';
        } else if (NguHanhRelationService.isKhac(dayCanHanh, monthCanHanh)) {
          canRelationKey = "Ngày khắc Tháng";
          canRelationDesc +=
              'Can ngày khắc Can tháng: Ngày chống khí tháng – khí nghịch.';
        } else {
          canRelationDesc += 'Quan hệ Can trung tính.';
        }
      } else {
        canRelationDesc += 'Không xác định được hành Can.';
      }
      analysisBuffer.writeln(canRelationDesc);
      totalScore += TimeConstant.khiThangCanCanScores[canRelationKey] ?? 0.0;

      // Phân tích Chi - Chi
      String chiRelationDesc =
          '• Chi ngày $dayChi ($dayChiHanh), Chi tháng $monthChi ($monthChiHanh) → ';
      String chiRelationKey = "Trung tính";
      if (dayChiHanh != 'N/A' && monthChiHanh != 'N/A') {
        if (NguHanhRelationService.isSinh(monthChiHanh, dayChiHanh)) {
          chiRelationKey = "Tháng sinh Ngày";
          chiRelationDesc +=
              'Chi tháng sinh Chi ngày: Khí tháng nâng đỡ ngày – rất vượng khí.';
        } else if (monthChiHanh == dayChiHanh) {
          chiRelationKey = "Đồng hành";
          chiRelationDesc +=
              'Chi tháng đồng hành Chi ngày: Khí tháng và ngày cùng hành – hòa hợp tuyệt đối.';
        } else if (NguHanhRelationService.isSinh(dayChiHanh, monthChiHanh)) {
          chiRelationKey = "Ngày sinh Tháng";
          chiRelationDesc +=
              'Chi ngày sinh Chi tháng: Ngày hao khí để sinh tháng – vẫn thuận tự nhiên.';
        } else if (NguHanhRelationService.isKhac(monthChiHanh, dayChiHanh)) {
          chiRelationKey = "Tháng khắc Ngày";
          chiRelationDesc +=
              'Chi tháng khắc Chi ngày: Trường khí tháng áp chế ngày – rất bất lợi.';
        } else if (NguHanhRelationService.isKhac(dayChiHanh, monthChiHanh)) {
          chiRelationKey = "Ngày khắc Tháng";
          chiRelationDesc +=
              'Chi ngày khắc Chi tháng: Ngày chống khí tháng – khí nghịch vừa phải.';
        } else {
          chiRelationDesc += 'Quan hệ Chi trung tính.';
        }
      } else {
        chiRelationDesc += 'Không xác định được hành Chi.';
      }
      analysisBuffer.writeln(chiRelationDesc);
      totalScore += TimeConstant.khiThangChiChiScores[chiRelationKey] ?? 0.0;

      // Tổng kết
      final String rating = TimeConstant.getKhiThangRating(totalScore);
      final String conclusion =
          TimeConstant.getKhiThangConclusion(totalScore, rating);
      // Thay thế 👉 bằng dấu mũi tên chuẩn
      final String finalConclusion = conclusion.replaceAll('→', '👉');

      return {
        'analysis': analysisBuffer.toString().trim(),
        'conclusion': finalConclusion
      };
    } catch (e, s) {
      LoggerUtils.error("Lỗi tính Khí Tháng chi tiết", e, s);
      return {'analysis': 'Lỗi tính toán Khí Tháng.', 'conclusion': 'Lỗi'};
    }
  }
}
  /// [REVISED] Tìm tiết khí cho một DateTime cụ thể, sử dụng thời gian chính xác.
  /// So sánh trực tiếp với startTimeLocal và endTimeLocal.
  /// Ưu tiên tiết khí mới nếu thời gian trùng khớp với thời điểm bắt đầu.
  /// Trả về tiết khí đang có hiệu lực TẠI THỜI ĐIỂM chính xác đó.
  static Map<String, dynamic>? getSolarTermForPreciseTime(
      DateTime targetDateTime) {
    final targetDateTimeLocal = targetDateTime.toLocal();
    final year = targetDateTimeLocal.year;

    final yearData = solarTermsByYear[year];
    if (yearData != null) {
      for (final term in yearData) {
        try {
          final DateTime startTime =
              DateTime.parse(term["startTimeLocal"]).toLocal();
          final String? endTimeStr = term["endTimeLocal"];
          DateTime? endTime =
              endTimeStr != null ? DateTime.parse(endTimeStr).toLocal() : null;

          if (!targetDateTimeLocal.isBefore(startTime) &&
              (endTime == null || targetDateTimeLocal.isBefore(endTime))) {
            return term;
          }
        } catch (e) {
          print(
              "Lỗi parse datetime (Precise Time): $e cho tiết khí ${term['name']} năm $year");
          continue;
        }
      }
    }

    final prevYearData = solarTermsByYear[year - 1];
    if (prevYearData != null && prevYearData.isNotEmpty) {
      final lastTermPrevYear = prevYearData.last;
      try {
        final DateTime startTimePrevYear =
            DateTime.parse(lastTermPrevYear["startTimeLocal"]).toLocal();
        final String? firstTermStartTimeStr =
            yearData?.first?['startTimeLocal'];
        DateTime? effectiveEndTime = firstTermStartTimeStr != null
            ? DateTime.parse(firstTermStartTimeStr).toLocal()
            : null;

        if (!targetDateTimeLocal.isBefore(startTimePrevYear) &&
            (effectiveEndTime == null ||
                targetDateTimeLocal.isBefore(effectiveEndTime))) {
          return lastTermPrevYear;
        }
      } catch (e) {
        print("Lỗi parse datetime cuối năm trước (Precise Time fallback): $e");
      }
    }

    LoggerUtils.error(
        "SolarTermsConstants: Không thể xác định Tiết Khí cho thời điểm ${targetDateTimeLocal.toIso8601String()}");
    return null;
  }

  /// [DÙNG ĐỂ TÍNH TRỰC] Tìm tiết khí có ngày bắt đầu <= ngày target.
  static Map<String, dynamic>? getSolarTermForDayCalculation(
      DateTime targetDateTime) {
    final targetDateTimeLocal = targetDateTime.toLocal();
    final targetDateOnly = DateTime(targetDateTimeLocal.year,
        targetDateTimeLocal.month, targetDateTimeLocal.day);
    Map<String, dynamic>? effectiveTerm;
    final year = targetDateOnly.year;

    final yearData = solarTermsByYear[year];
    if (yearData != null) {
      for (final term in yearData) {
        try {
          final DateTime startTime =
              DateTime.parse(term["startTimeLocal"]).toLocal();
          final startDateOnly =
              DateTime(startTime.year, startTime.month, startTime.day);

          if (startDateOnly.isAtSameMomentAs(targetDateOnly) ||
              startDateOnly.isBefore(targetDateOnly)) {
            effectiveTerm = term;
          } else {
            break;
          }
        } catch (e) {
          print(
              "Lỗi parse datetime (Date-Based Logic): $e cho tiết khí ${term['name']} năm $year");
          continue;
        }
      }
    }

    if (effectiveTerm == null) {
      final prevYearData = solarTermsByYear[year - 1];
      if (prevYearData != null && prevYearData.isNotEmpty) {
        final lastTermPrevYear = prevYearData.last;
        try {
          final DateTime startTimePrevYear =
              DateTime.parse(lastTermPrevYear["startTimeLocal"]).toLocal();
          final startDateOnlyPrevYear = DateTime(startTimePrevYear.year,
              startTimePrevYear.month, startTimePrevYear.day);
          if (startDateOnlyPrevYear.isAtSameMomentAs(targetDateOnly) ||
              startDateOnlyPrevYear.isBefore(targetDateOnly)) {
            effectiveTerm = lastTermPrevYear;
          }
        } catch (e) {
          print(
              "Lỗi parse datetime cuối năm trước (Date-Based Logic fallback): $e");
        }
      }
    }

    if (effectiveTerm == null) {
      LoggerUtils.error(
          "SolarTermsConstants: Không thể xác định Tiết Khí cho tính toán ngày ${dateFormat.format(targetDateOnly)}");
    }
    return effectiveTerm;
  }

  static final DateFormat dateFormat = DateFormat('dd/MM/yyyy');
}
