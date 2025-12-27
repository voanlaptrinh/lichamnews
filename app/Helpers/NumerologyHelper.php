<?php

namespace App\Helpers;

/**
 * Comprehensive Numerology Helper
 * Bao gồm tất cả các tính năng thần số học
 */
class NumerologyHelper
{
    // Bảng chuyển đổi chữ cái sang số - Bao gồm tiếng Việt có dấu
    private static $letterToNumber = [
        // Chữ cái không dấu
        'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9,
        'J' => 1, 'K' => 2, 'L' => 3, 'M' => 4, 'N' => 5, 'O' => 6, 'P' => 7, 'Q' => 8, 'R' => 9,
        'S' => 1, 'T' => 2, 'U' => 3, 'V' => 4, 'W' => 5, 'X' => 6, 'Y' => 7, 'Z' => 8,

        // Tiếng Việt có dấu - A
        'À' => 1, 'Á' => 1, 'Ạ' => 1, 'Ả' => 1, 'Ã' => 1,
        'Â' => 1, 'Ầ' => 1, 'Ấ' => 1, 'Ậ' => 1, 'Ẩ' => 1, 'Ẫ' => 1,
        'Ă' => 1, 'Ằ' => 1, 'Ắ' => 1, 'ặ' => 1, 'Ẳ' => 1, 'Ẵ' => 1,

        // Tiếng Việt có dấu - E
        'È' => 5, 'É' => 5, 'Ẹ' => 5, 'Ẻ' => 5, 'Ẽ' => 5,
        'Ê' => 5, 'Ề' => 5, 'Ế' => 5, 'Ệ' => 5, 'Ể' => 5, 'Ễ' => 5,

        // Tiếng Việt có dấu - I
        'Ì' => 9, 'Í' => 9, 'Ị' => 9, 'Ỉ' => 9, 'Ĩ' => 9,

        // Tiếng Việt có dấu - O
        'Ò' => 6, 'Ó' => 6, 'Ọ' => 6, 'Ỏ' => 6, 'Õ' => 6,
        'Ô' => 6, 'Ồ' => 6, 'Ố' => 6, 'Ộ' => 6, 'Ổ' => 6, 'Ỗ' => 6,
        'Ơ' => 6, 'Ờ' => 6, 'Ớ' => 6, 'Ợ' => 6, 'Ở' => 6, 'Ỡ' => 6,

        // Tiếng Việt có dấu - U
        'Ù' => 3, 'Ú' => 3, 'Ụ' => 3, 'Ủ' => 3, 'Ũ' => 3,
        'Ư' => 3, 'Ừ' => 3, 'Ứ' => 3, 'Ự' => 3, 'Ử' => 3, 'Ữ' => 3,

        // Tiếng Việt có dấu - Y
        'Ỳ' => 7, 'Ý' => 7, 'Ỵ' => 7, 'Ỷ' => 7, 'Ỹ' => 7,

        // Tiếng Việt có dấu - Đ
        'Đ' => 4,

        // Chữ thường (lowercase)
        'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8, 'i' => 9,
        'j' => 1, 'k' => 2, 'l' => 3, 'm' => 4, 'n' => 5, 'o' => 6, 'p' => 7, 'q' => 8, 'r' => 9,
        's' => 1, 't' => 2, 'u' => 3, 'v' => 4, 'w' => 5, 'x' => 6, 'y' => 7, 'z' => 8,

        // Tiếng Việt chữ thường
        'à' => 1, 'á' => 1, 'ạ' => 1, 'ả' => 1, 'ã' => 1,
        'â' => 1, 'ầ' => 1, 'ấ' => 1, 'ậ' => 1, 'ẩ' => 1, 'ẫ' => 1,
        'ă' => 1, 'ằ' => 1, 'ắ' => 1, 'ặ' => 1, 'ẳ' => 1, 'ẵ' => 1,
        'è' => 5, 'é' => 5, 'ẹ' => 5, 'ẻ' => 5, 'ẽ' => 5,
        'ê' => 5, 'ề' => 5, 'ế' => 5, 'ệ' => 5, 'ể' => 5, 'ễ' => 5,
        'ì' => 9, 'í' => 9, 'ị' => 9, 'ỉ' => 9, 'ĩ' => 9,
        'ò' => 6, 'ó' => 6, 'ọ' => 6, 'ỏ' => 6, 'õ' => 6,
        'ô' => 6, 'ồ' => 6, 'ố' => 6, 'ộ' => 6, 'ổ' => 6, 'ỗ' => 6,
        'ơ' => 6, 'ờ' => 6, 'ớ' => 6, 'ợ' => 6, 'ở' => 6, 'ỡ' => 6,
        'ù' => 3, 'ú' => 3, 'ụ' => 3, 'ủ' => 3, 'ũ' => 3,
        'ư' => 3, 'ừ' => 3, 'ứ' => 3, 'ự' => 3, 'ử' => 3, 'ữ' => 3,
        'ỳ' => 7, 'ý' => 7, 'ỵ' => 7, 'ỷ' => 7, 'ỹ' => 7,
        'đ' => 4
    ];

    // Nguyên âm - Bao gồm tiếng Việt
    private static $vowels = [
        'A', 'E', 'I', 'O', 'U', 'Y',
        'a', 'e', 'i', 'o', 'u', 'y',
        // Tiếng Việt có dấu
        'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'ặ', 'Ẳ', 'Ẵ',
        'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
        'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ',
        'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
        'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
        'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ',
        'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
        'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
        'ì', 'í', 'ị', 'ỉ', 'ĩ',
        'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
        'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
        'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ'
    ];

    /**
     * Tính số chủ đạo (Life Path Number)
     */
    public static function calculateLifePath($birthDate)
    {
        if (is_array($birthDate)) {
            $day = $birthDate['day'];
            $month = $birthDate['month'];
            $year = $birthDate['year'];
        } else {
            $timestamp = strtotime($birthDate);
            $day = date('d', $timestamp);
            $month = date('m', $timestamp);
            $year = date('Y', $timestamp);
        }

        // Tính toán chi tiết từng bước
        $daySum = self::reduceToSingleDigit($day);
        $monthSum = self::reduceToSingleDigit($month);
        $yearSum = self::reduceToSingleDigit($year);

        $totalSum = $daySum + $monthSum + $yearSum;
        $lifePathNumber = self::reduceToSingleDigit($totalSum);

        $calculation = "Ngày: {$day} → {$daySum}, Tháng: {$month} → {$monthSum}, Năm: {$year} → {$yearSum}\n";
        $calculation .= "Tổng: {$daySum} + {$monthSum} + {$yearSum} = {$totalSum} → {$lifePathNumber}";

        return [
            'number' => $lifePathNumber,
            'calculation' => $calculation,
            'interpretation' => self::getLifePathInterpretation($lifePathNumber),
            'sections' => self::getLifePathSections($lifePathNumber)
        ];
    }

    /**
     * Tính số ngày sinh (Birth Day Number)
     */
    public static function calculateBirthDayNumber($birthDate)
    {
        $day = is_array($birthDate) ? $birthDate['day'] : date('d', strtotime($birthDate));
        $birthDayNumber = self::reduceToSingleDigit($day);

        return [
            'number' => $birthDayNumber,
            'original_day' => $day,
            'calculation' => "Ngày sinh: {$day} → {$birthDayNumber}",
            'interpretation' => self::getBirthDayInterpretation($birthDayNumber),
            'sections' => self::getBirthDaySections($birthDayNumber)
        ];
    }

    /**
     * Tính số tên (Expression Number)
     */
    public static function calculateExpressionNumber($fullName)
    {
        $calculation = "";
        $totalValue = 0;
        $nameBreakdown = [];

        // Giữ nguyên dấu, chỉ loại bỏ khoảng trắng thừa
        $words = explode(' ', trim($fullName));
        $words = array_filter($words); // Loại bỏ phần tử rỗng

        foreach ($words as $word) {
            $wordValue = 0;
            $wordBreakdown = "";

            // Sử dụng mb_str_split để xử lý UTF-8 đúng cách
            $letters = self::mb_str_split($word);

            foreach ($letters as $letter) {
                if (isset(self::$letterToNumber[$letter])) {
                    $value = self::$letterToNumber[$letter];
                    $wordValue += $value;
                    $wordBreakdown .= "{$letter}({$value}) ";
                }
            }

            if ($wordValue > 0) {
                $nameBreakdown[] = [
                    'word' => $word,
                    'breakdown' => trim($wordBreakdown),
                    'sum' => $wordValue
                ];
                $totalValue += $wordValue;
            }
        }

        $expressionNumber = self::reduceToSingleDigit($totalValue);

        // Tạo chuỗi giải thích
        $calculation = "Tên: {$fullName}\n";
        foreach ($nameBreakdown as $wordData) {
            $calculation .= "{$wordData['word']}: {$wordData['breakdown']} = {$wordData['sum']}\n";
        }
        $calculation .= "Tổng: {$totalValue} → {$expressionNumber}";

        return [
            'number' => $expressionNumber,
            'total_value' => $totalValue,
            'calculation' => $calculation,
            'name_breakdown' => $nameBreakdown,
            'interpretation' => self::getExpressionInterpretation($expressionNumber),
            'sections' => self::getExpressionSections($expressionNumber)
        ];
    }

    /**
     * Tính số linh hồn (Soul Urge Number)
     */
    public static function calculateSoulUrge($fullName)
    {
        $calculation = "";
        $totalValue = 0;
        $vowelBreakdown = [];

        $words = explode(' ', trim($fullName));
        $words = array_filter($words);

        foreach ($words as $word) {
            $wordValue = 0;
            $wordVowels = "";

            $letters = self::mb_str_split($word);

            foreach ($letters as $letter) {
                if (in_array($letter, self::$vowels) && isset(self::$letterToNumber[$letter])) {
                    $value = self::$letterToNumber[$letter];
                    $wordValue += $value;
                    $wordVowels .= "{$letter}({$value}) ";
                }
            }

            if ($wordValue > 0) {
                $vowelBreakdown[] = [
                    'word' => $word,
                    'vowels' => trim($wordVowels),
                    'sum' => $wordValue
                ];
                $totalValue += $wordValue;
            }
        }

        $soulUrgeNumber = self::reduceToSingleDigit($totalValue);

        // Tạo chuỗi giải thích
        $calculation = "Nguyên âm trong tên: {$fullName}\n";
        foreach ($vowelBreakdown as $wordData) {
            $calculation .= "{$wordData['word']}: {$wordData['vowels']} = {$wordData['sum']}\n";
        }
        $calculation .= "Tổng: {$totalValue} → {$soulUrgeNumber}";

        return [
            'number' => $soulUrgeNumber,
            'total_value' => $totalValue,
            'calculation' => $calculation,
            'vowel_breakdown' => $vowelBreakdown,
            'interpretation' => self::getSoulUrgeInterpretation($soulUrgeNumber),
            'sections' => self::getSoulUrgeSections($soulUrgeNumber)
        ];
    }

    /**
     * Tính số tính cách (Personality Number)
     */
    public static function calculatePersonalityNumber($fullName)
    {
        $calculation = "";
        $totalValue = 0;
        $consonantBreakdown = [];

        $words = explode(' ', trim($fullName));
        $words = array_filter($words);

        foreach ($words as $word) {
            $wordValue = 0;
            $wordConsonants = "";

            $letters = self::mb_str_split($word);

            foreach ($letters as $letter) {
                if (!in_array($letter, self::$vowels) && isset(self::$letterToNumber[$letter])) {
                    $value = self::$letterToNumber[$letter];
                    $wordValue += $value;
                    $wordConsonants .= "{$letter}({$value}) ";
                }
            }

            if ($wordValue > 0) {
                $consonantBreakdown[] = [
                    'word' => $word,
                    'consonants' => trim($wordConsonants),
                    'sum' => $wordValue
                ];
                $totalValue += $wordValue;
            }
        }

        $personalityNumber = self::reduceToSingleDigit($totalValue);

        // Tạo chuỗi giải thích
        $calculation = "Phụ âm trong tên: {$fullName}\n";
        foreach ($consonantBreakdown as $wordData) {
            $calculation .= "{$wordData['word']}: {$wordData['consonants']} = {$wordData['sum']}\n";
        }
        $calculation .= "Tổng: {$totalValue} → {$personalityNumber}";

        return [
            'number' => $personalityNumber,
            'total_value' => $totalValue,
            'calculation' => $calculation,
            'consonant_breakdown' => $consonantBreakdown,
            'interpretation' => self::getPersonalityInterpretation($personalityNumber),
            'sections' => self::getPersonalitySections($personalityNumber)
        ];
    }

    /**
     * Tính biểu đồ ngày sinh (Birth Chart) - chỉ từ ngày sinh
     */
    public static function calculateBirthChart($birthDate)
    {
        if (is_array($birthDate)) {
            $dateString = sprintf("%02d%02d%d", $birthDate['day'], $birthDate['month'], $birthDate['year']);
        } else {
            $timestamp = strtotime($birthDate);
            $dateString = date('dmY', $timestamp);
        }

        // Đếm tần suất xuất hiện của từng số trong ngày sinh
        $frequencies = array_fill(0, 10, 0);

        for ($i = 0; $i < strlen($dateString); $i++) {
            $digit = intval($dateString[$i]);
            $frequencies[$digit]++;
        }

        // Tính số thiếu hụt từ ngày sinh
        $missingNumbers = [];
        for ($i = 1; $i <= 9; $i++) {
            if ($frequencies[$i] == 0) {
                $missingNumbers[] = $i;
            }
        }

        // Tính số tiềm năng từ ngày sinh
        $dominantNumbers = [];
        for ($i = 1; $i <= 9; $i++) {
            if ($frequencies[$i] >= 3) {
                $dominantNumbers[] = ['number' => $i, 'frequency' => $frequencies[$i]];
            }
        }

        // Tạo frequency interpretations cho từng số
        $frequencyInterpretations = [];
        for ($i = 1; $i <= 9; $i++) {
            $frequency = $frequencies[$i] ?? 0;
            $frequencyInterpretations[$i] = [
                'number' => $i,
                'frequency' => $frequency,
                'interpretation' => self::getFrequencyInterpretation($i, $frequency)
            ];
        }

        return [
            'birth_date_string' => $dateString,
            'frequencies' => $frequencies,
            'missing_numbers' => $missingNumbers,
            'dominant_numbers' => $dominantNumbers,
            'chart_grid' => self::buildChartGrid($frequencies),
            'frequency_interpretations' => $frequencyInterpretations,
            'interpretation' => self::getBirthChartInterpretation($frequencies, $missingNumbers, $dominantNumbers),
            'sections' => self::getBirthChartSections($frequencies, $missingNumbers, $dominantNumbers)
        ];
    }

    /**
     * Tính số thiếu hụt từ tên (Missing Numbers from Name)
     */
    public static function calculateMissingNumbersFromName($fullName)
    {
        $letterFrequencies = [];
        $name = preg_replace('/[^A-Za-zÀ-ỹĐđ]/', '', $fullName);
        $letters = self::mb_str_split($name);

        // Đếm tần suất chữ cái trong tên
        foreach ($letters as $letter) {
            if (isset(self::$letterToNumber[$letter])) {
                $number = self::$letterToNumber[$letter];
                $letterFrequencies[$number] = ($letterFrequencies[$number] ?? 0) + 1;
            }
        }

        // Tìm số thiếu hụt từ tên (1-9)
        $missingNumbers = [];
        for ($i = 1; $i <= 9; $i++) {
            if (!isset($letterFrequencies[$i]) || $letterFrequencies[$i] == 0) {
                $missingNumbers[] = $i;
            }
        }

        // Tìm số tiềm năng (số xuất hiện nhiều nhất)
        $hiddenPassions = [];
        if (!empty($letterFrequencies)) {
            $maxFrequency = max($letterFrequencies);
            foreach ($letterFrequencies as $number => $frequency) {
                if ($frequency == $maxFrequency && $maxFrequency > 1) {
                    $hiddenPassions[] = $number;
                }
            }
        }

        return [
            'missing_numbers' => $missingNumbers,
            'hidden_passions' => $hiddenPassions,
            'letter_frequencies' => $letterFrequencies,
            'interpretation' => self::getMissingNumbersInterpretation($missingNumbers, $hiddenPassions),
            'sections' => self::getMissingNumbersSections($missingNumbers, $hiddenPassions)
        ];
    }

    /**
     * Tính mui tên cá tính (Arrow Patterns)
     */
    public static function calculateArrows($birthChart)
    {
        $frequencies = $birthChart['frequencies'] ?? [];
        $arrows = [];

        // Định nghĩa các mui tên (8 mũi tên đầy đủ theo source_code)
        $arrowPatterns = [
            'arrow_of_planning' => [1, 2, 3],      // Mũi tên Kế hoạch
            'arrow_of_will' => [4, 5, 6],          // Mũi tên Ý chí
            'arrow_of_action' => [7, 8, 9],        // Mũi tên Hành động
            'arrow_of_practical' => [1, 4, 7],     // Mũi tên Thực tế
            'arrow_of_emotional' => [2, 5, 8],     // Mũi tên Cảm xúc
            'arrow_of_intelligence' => [3, 6, 9],  // Mũi tên Trí tuệ
            'arrow_of_determination' => [1, 5, 9], // Mũi tên Quyết tâm
            'arrow_of_spiritual' => [3, 5, 7]      // Mũi tên Tâm linh
        ];

        $missingArrows = [
            'missing_arrow_of_planning' => [1, 2, 3],
            'missing_arrow_of_will' => [4, 5, 6],
            'missing_arrow_of_action' => [7, 8, 9],
            'missing_arrow_of_practical' => [1, 4, 7],
            'missing_arrow_of_emotional' => [2, 5, 8],
            'missing_arrow_of_intelligence' => [3, 6, 9],
            'missing_arrow_of_determination' => [1, 5, 9],
            'missing_arrow_of_spiritual' => [3, 5, 7]
        ];

        // Kiểm tra mui tên có mặt
        foreach ($arrowPatterns as $arrowName => $numbers) {
            $hasArrow = true;
            foreach ($numbers as $num) {
                if ($frequencies[$num] == 0) {
                    $hasArrow = false;
                    break;
                }
            }

            if ($hasArrow) {
                $arrows[] = [
                    'name' => $arrowName,
                    'numbers' => $numbers,
                    'type' => 'present',
                    'interpretation' => self::getArrowInterpretation($arrowName, true)
                ];
            }
        }

        // Kiểm tra mui tên thiếu
        foreach ($missingArrows as $arrowName => $numbers) {
            $missingCount = 0;
            foreach ($numbers as $num) {
                if ($frequencies[$num] == 0) {
                    $missingCount++;
                }
            }

            if ($missingCount == count($numbers)) {
                $arrows[] = [
                    'name' => $arrowName,
                    'numbers' => $numbers,
                    'type' => 'missing',
                    'interpretation' => self::getArrowInterpretation($arrowName, false)
                ];
            }
        }

        return [
            'arrows' => $arrows,
            'interpretation' => self::getArrowsInterpretation($arrows),
            'sections' => self::getArrowsSections($arrows)
        ];
    }

    /**
     * Tính số thái độ (Attitude Number)
     */
    public static function calculateAttitudeNumber($birthDate)
    {
        if (is_array($birthDate)) {
            $day = $birthDate['day'];
            $month = $birthDate['month'];
        } else {
            $timestamp = strtotime($birthDate);
            $day = date('d', $timestamp);
            $month = date('m', $timestamp);
        }

        $sum = $day + $month;
        $attitudeNumber = self::reduceToSingleDigit($sum);

        return [
            'number' => $attitudeNumber,
            'calculation' => "Ngày: {$day} + Tháng: {$month} = {$sum} → {$attitudeNumber}",
            'interpretation' => self::getAttitudeInterpretation($attitudeNumber),
            'sections' => self::getAttitudeSections($attitudeNumber)
        ];
    }

    /**
     * Tính số trưởng thành (Maturity Number)
     */
    public static function calculateMaturityNumber($birthDate, $fullName)
    {
        $lifePath = self::calculateLifePath($birthDate);
        $expression = self::calculateExpressionNumber($fullName);

        $sum = $lifePath['number'] + $expression['number'];
        $maturityNumber = self::reduceToSingleDigit($sum);

        return [
            'number' => $maturityNumber,
            'life_path' => $lifePath['number'],
            'expression' => $expression['number'],
            'calculation' => "Số chủ đạo: {$lifePath['number']} + Số tên: {$expression['number']} = {$sum} → {$maturityNumber}",
            'interpretation' => self::getMaturityInterpretation($maturityNumber),
            'sections' => self::getMaturitySections($maturityNumber)
        ];
    }

    /**
     * Tính năm cá nhân (Personal Year)
     */
    public static function calculatePersonalYear($birthDate, $currentYear = null)
    {
        if (!$currentYear) {
            $currentYear = date('Y');
        }

        if (is_array($birthDate)) {
            $day = $birthDate['day'];
            $month = $birthDate['month'];
        } else {
            $timestamp = strtotime($birthDate);
            $day = date('d', $timestamp);
            $month = date('m', $timestamp);
        }

        // Rút gọn năm hiện tại trước khi tính toán
        $reducedYear = self::reduceToSingleDigitAlways($currentYear);
        $sum = $day + $month + $reducedYear;
        $personalYear = self::reduceToSingleDigitAlways($sum);

        return [
            'number' => $personalYear,
            'year' => $currentYear,
            'calculation' => "Ngày: {$day} + Tháng: {$month} + Năm: {$currentYear} → {$reducedYear} = {$sum} → {$personalYear}",
            'interpretation' => self::getPersonalYearInterpretation($personalYear),
            'sections' => self::getPersonalYearSections($personalYear)
        ];
    }

    /**
     * Tính chu kỳ 9 năm (Nine Year Cycle)
     */
    public static function calculateNineYearCycle($birthDate, $startYear = null)
    {
        if (!$startYear) {
            $startYear = date('Y') - 4; // Bắt đầu từ 5 năm trước
        }

        $cycles = [];
        for ($i = 0; $i < 9; $i++) {
            $year = $startYear + $i;
            $personalYearData = self::calculatePersonalYear($birthDate, $year);

            $cycles[] = [
                'year' => $year,
                'personal_year' => $personalYearData['number'],
                'phase' => self::getNineYearPhase($personalYearData['number']),
                'interpretation' => $personalYearData['interpretation']
            ];
        }

        return [
            'start_year' => $startYear,
            'end_year' => $startYear + 8,
            'cycles' => $cycles,
            'interpretation' => 'Chu kỳ 9 năm cho thấy các giai đoạn phát triển trong cuộc đời bạn.',
            'current_phase' => self::getCurrentPhase($cycles)
        ];
    }

    /**
     * Tính 4 đỉnh cao cuộc đời (Life Pinnacles)
     */
    public static function calculateLifePinnacles($birthDate)
    {
        if (is_array($birthDate)) {
            $day = $birthDate['day'];
            $month = $birthDate['month'];
            $year = $birthDate['year'];
        } else {
            $timestamp = strtotime($birthDate);
            $day = date('d', $timestamp);
            $month = date('m', $timestamp);
            $year = date('Y', $timestamp);
        }

        $lifePathData = self::calculateLifePath($birthDate);
        $lifePath = $lifePathData['number'];

        // Tính 4 đỉnh cao
        $pinnacle1 = self::reduceToSingleDigit($month + $day);
        $pinnacle2 = self::reduceToSingleDigit($day + $year);
        $pinnacle3 = self::reduceToSingleDigit($pinnacle1 + $pinnacle2);
        $pinnacle4 = self::reduceToSingleDigit($month + $year);

        // Tính độ tuổi chuyển giai đoạn
        $age1End = 36 - $lifePath;
        $age2End = $age1End + 9;
        $age3End = $age2End + 9;

        $currentYear = date('Y');
        $currentAge = $currentYear - $year;

        // Xác định giai đoạn hiện tại
        $currentPinnacle = 1;
        if ($currentAge > $age3End) {
            $currentPinnacle = 4;
        } elseif ($currentAge > $age2End) {
            $currentPinnacle = 3;
        } elseif ($currentAge > $age1End) {
            $currentPinnacle = 2;
        }

        return [
            'pinnacles' => [
                1 => [
                    'number' => $pinnacle1,
                    'age_range' => "0 - {$age1End}",
                    'phase' => 'Giai đoạn hình thành',
                    'interpretation' => self::getPinnacleInterpretation($pinnacle1, 1)
                ],
                2 => [
                    'number' => $pinnacle2,
                    'age_range' => ($age1End + 1) . " - {$age2End}",
                    'phase' => 'Giai đoạn phát triển',
                    'interpretation' => self::getPinnacleInterpretation($pinnacle2, 2)
                ],
                3 => [
                    'number' => $pinnacle3,
                    'age_range' => ($age2End + 1) . " - {$age3End}",
                    'phase' => 'Giai đoạn thu hoạch',
                    'interpretation' => self::getPinnacleInterpretation($pinnacle3, 3)
                ],
                4 => [
                    'number' => $pinnacle4,
                    'age_range' => ($age3End + 1) . "+",
                    'phase' => 'Giai đoạn trí tuệ',
                    'interpretation' => self::getPinnacleInterpretation($pinnacle4, 4)
                ]
            ],
            'current_age' => $currentAge,
            'current_pinnacle' => $currentPinnacle,
            'calculation' => "Đỉnh 1: ({$month}+{$day})→{$pinnacle1}, Đỉnh 2: ({$day}+{$year})→{$pinnacle2}, Đỉnh 3: ({$pinnacle1}+{$pinnacle2})→{$pinnacle3}, Đỉnh 4: ({$month}+{$year})→{$pinnacle4}"
        ];
    }

    /**
     * Tính 4 năng lực bẩm sinh (Innate Abilities)
     */

    /**
     * Tính số thiếu hụt (Karmic Lessons)
     */
    public static function calculateKarmicLessons($fullName)
    {
        $letterFrequencies = [];
        $name = preg_replace('/[^A-Za-zÀ-ỹĐđ]/', '', $fullName);
        $letters = self::mb_str_split($name);

        // Đếm tần suất chữ cái
        foreach ($letters as $letter) {
            if (isset(self::$letterToNumber[$letter])) {
                $number = self::$letterToNumber[$letter];
                $letterFrequencies[$number] = ($letterFrequencies[$number] ?? 0) + 1;
            }
        }

        // Tìm số thiếu hụt (1-9)
        $missingNumbers = [];
        for ($i = 1; $i <= 9; $i++) {
            if (!isset($letterFrequencies[$i]) || $letterFrequencies[$i] == 0) {
                $missingNumbers[] = $i;
            }
        }

        // Tìm số tiềm năng (số xuất hiện nhiều nhất)
        $hiddenPassions = [];
        if (!empty($letterFrequencies)) {
            $maxFrequency = max($letterFrequencies);
            foreach ($letterFrequencies as $number => $frequency) {
                if ($frequency == $maxFrequency && $maxFrequency > 1) {
                    $hiddenPassions[] = $number;
                }
            }
        }

        $karmicLessons = [];
        if (empty($missingNumbers)) {
            // Trường hợp không thiếu số nào
            $allNumbersData = self::getKarmicLessonInterpretation('all_numbers');
            $karmicLessons[] = [
                'number' => 0,
                'title' => $allNumbersData['title'],
                'meaning' => $allNumbersData['meaning']
            ];
        } else {
            // Trường hợp có số thiếu hụt
            foreach ($missingNumbers as $num) {
                $lessonData = self::getKarmicLessonInterpretation($num);
                $karmicLessons[] = [
                    'number' => $num,
                    'title' => $lessonData['title'],
                    'meaning' => $lessonData['meaning']
                ];
            }
        }

        return [
            'missing_numbers' => $missingNumbers,
            'hidden_passions' => $hiddenPassions,
            'letter_frequencies' => $letterFrequencies,
            'karmic_lessons' => $karmicLessons,
            'interpretation' => self::getKarmicLessonsInterpretation($missingNumbers, $hiddenPassions)
        ];
    }

    /**
     * Tính số nghiệp quả (Karmic Debt)
     */
    public static function calculateKarmicDebt($birthDate, $fullName)
    {
        $karmicDebtNumbers = [13, 14, 16, 19];
        $foundDebts = [];

        // Kiểm tra trong ngày sinh
        if (is_array($birthDate)) {
            $day = $birthDate['day'];
            $month = $birthDate['month'];
            $year = $birthDate['year'];
        } else {
            $timestamp = strtotime($birthDate);
            $day = date('d', $timestamp);
            $month = date('m', $timestamp);
            $year = date('Y', $timestamp);
        }

        // Kiểm tra ngày
        if (in_array($day, $karmicDebtNumbers)) {
            $foundDebts[] = [
                'number' => $day,
                'source' => 'Ngày sinh',
                'interpretation' => self::getKarmicDebtInterpretation($day)
            ];
        }

        // Kiểm tra trong tính toán tên
        $expressionData = self::calculateExpressionNumber($fullName);
        if (in_array($expressionData['total_value'], $karmicDebtNumbers)) {
            $foundDebts[] = [
                'number' => $expressionData['total_value'],
                'source' => 'Số tên (trước khi rút gọn)',
                'interpretation' => self::getKarmicDebtInterpretation($expressionData['total_value'])
            ];
        }

        return [
            'karmic_debts' => $foundDebts,
            'has_karmic_debt' => !empty($foundDebts),
            'interpretation' => empty($foundDebts)
                ? 'Bạn không mang theo nghiệp quả từ kiếp trước.'
                : 'Bạn có một số nghiệp quả cần giải quyết trong kiếp này.',
            'sections' => self::getKarmicDebtSections($foundDebts)
        ];
    }

    /**
     * Helper method: Rút gọn số về 1 chữ số (trừ master numbers 11, 22, 33)
     */
    private static function reduceToSingleDigit($number)
    {
        while ($number > 9 && !in_array($number, [11, 22, 33])) {
            $sum = 0;
            $digits = str_split((string)$number);
            foreach ($digits as $digit) {
                $sum += intval($digit);
            }
            $number = $sum;
        }
        return $number;
    }

    /**
     * Helper method: Rút gọn số về 1 chữ số (không giữ master numbers)
     * Dùng cho tính toán năm cá nhân
     */
    private static function reduceToSingleDigitAlways($number)
    {
        while ($number > 9) {
            $sum = 0;
            $digits = str_split((string)$number);
            foreach ($digits as $digit) {
                $sum += intval($digit);
            }
            $number = $sum;
        }
        return $number;
    }

    /**
     * Split string thành array các ký tự UTF-8
     */
    private static function mb_str_split($string, $length = 1, $encoding = 'UTF-8')
    {
        $result = [];
        $string_length = mb_strlen($string, $encoding);
        for ($i = 0; $i < $string_length; $i += $length) {
            $result[] = mb_substr($string, $i, $length, $encoding);
        }
        return $result;
    }

    /**
     * Xây dựng lưới biểu đồ 3x3
     */
    private static function buildChartGrid($frequencies)
    {
        // Lưới Pythagorean 3x3
        $grid = [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9]
        ];

        $result = [];
        for ($row = 0; $row < 3; $row++) {
            for ($col = 0; $col < 3; $col++) {
                $number = $grid[$row][$col];
                $result[$row][$col] = [
                    'number' => $number,
                    'frequency' => $frequencies[$number] ?? 0
                ];
            }
        }

        return $result;
    }

    // ========================
    // INTERPRETATION METHODS
    // ========================

    private static function getLifePathInterpretation($number)
    {
        $interpretations = [
            1 => 'Bạn là người tiên phong, độc lập và có khả năng lãnh đạo tự nhiên.',
            2 => 'Bạn là người hòa giải, hợp tác và có khả năng làm việc nhóm xuất sắc.',
            3 => 'Bạn là người sáng tạo, giao tiếp tốt và có tài năng nghệ thuật.',
            4 => 'Bạn là người thực tế, cần cù và có khả năng xây dựng nền tảng vững chắc.',
            5 => 'Bạn là người tự do, phiêu lưu và thích khám phá những điều mới mẻ.',
            6 => 'Bạn là người có trách nhiệm, yêu thương gia đình và muốn chăm sóc người khác.',
            7 => 'Bạn là người tâm linh, trí tuệ và thích tìm hiểu bản chất sâu xa của sự vật.',
            8 => 'Bạn là người có tham vọng, quyền lực và khả năng kinh doanh xuất sắc.',
            9 => 'Bạn là người nhân đạo, rộng lượng và muốn phục vụ cộng đồng.',
            11 => 'Bạn có trực giác mạnh mẽ và khả năng truyền cảm hứng cho người khác.',
            22 => 'Bạn có tầm nhìn lớn và khả năng biến ước mơ thành hiện thực.',
            33 => 'Bạn là thầy cô tâm linh, có khả năng chữa lành và nâng cao tâm hồn người khác.'
        ];

        return $interpretations[$number] ?? 'Không có thông tin diễn giải.';
    }

    private static function getLifePathSections($number)
    {
        // Trả về các sections chi tiết cho từng số
        return [
            [
                'title' => 'Điểm mạnh',
                'content' => self::getLifePathStrengths($number)
            ],
            [
                'title' => 'Thách thức',
                'content' => self::getLifePathChallenges($number)
            ],
            [
                'title' => 'Sự nghiệp phù hợp',
                'content' => self::getLifePathCareers($number)
            ]
        ];
    }

    private static function getLifePathStrengths($number)
    {
        $strengths = [
            1 => 'Lãnh đạo, sáng tạo, độc lập, quyết đoán, tiên phong',
            2 => 'Hợp tác, nhạy cảm, kiên nhẫn, hòa giải, lắng nghe',
            3 => 'Sáng tạo, giao tiếp, lạc quan, nghệ thuật, truyền cảm hứng',
            4 => 'Thực tế, tổ chức, kiên trì, đáng tin cậy, cần cù',
            5 => 'Linh hoạt, tự do, phiêu lưu, giao tiếp, đa tài',
            6 => 'Chăm sóc, trách nhiệm, yêu thương, chữa lành, gia đình',
            7 => 'Phân tích, trực giác, tâm linh, nghiên cứu, suy ngẫm',
            8 => 'Tham vọng, kinh doanh, tổ chức, quyền lực, thực tế',
            9 => 'Nhân đạo, rộng lượng, trí tuệ, nghệ thuật, phục vụ'
        ];

        return $strengths[$number] ?? 'Chưa có thông tin';
    }

    private static function getLifePathChallenges($number)
    {
        $challenges = [
            1 => 'Kiêu ngạo, độc đoán, thiếu kiên nhẫn, ích kỷ',
            2 => 'Quá nhạy cảm, thiếu tự tin, phụ thuộc, do dự',
            3 => 'Thiếu tập trung, nông cạn, nói nhiều, phân tán',
            4 => 'Cứng nhắc, chậm chạp, quá thận trọng, nhàm chán',
            5 => 'Không kiên trì, bốc đồng, thiếu trách nhiệm, phung phí',
            6 => 'Can thiệp quá mức, tự hi sinh, kiểm soát, lo lắng',
            7 => 'Cô lập, hoài nghi, lạnh lùng, khó tiếp cận',
            8 => 'Tham lam, độc đoán, vật chất, áp lực, căng thẳng',
            9 => 'Lý tưởng hóa, không thực tế, dễ thất vọng, hy sinh quá mức'
        ];

        return $challenges[$number] ?? 'Chưa có thông tin';
    }

    private static function getLifePathCareers($number)
    {
        $careers = [
            1 => 'CEO, doanh nhân, lãnh đạo, nhà phát minh, nhà thiết kế',
            2 => 'Tư vấn, điều phối, nhà ngoại giao, giáo viên, y tá',
            3 => 'Nghệ sĩ, nhà văn, diễn viên, MC, thiết kế, quảng cáo',
            4 => 'Kỹ sư, kế toán, xây dựng, quản lý, nhân viên ngân hàng',
            5 => 'Du lịch, báo chí, bán hàng, marketing, vận chuyển',
            6 => 'Giáo viên, y tá, tư vấn, xã hội, thiết kế nội thất',
            7 => 'Nghiên cứu, tâm lý, triết học, khoa học, tâm linh',
            8 => 'Kinh doanh, tài chính, bất động sản, luật, quản lý',
            9 => 'Giáo dục, từ thiện, nghệ thuật, y tế, tôn giáo'
        ];

        return $careers[$number] ?? 'Chưa có thông tin';
    }

    private static function getBirthDayInterpretation($number)
    {
        $interpretations = self::getBirthDayInterpretationsData();
        if (isset($interpretations[$number])) {
            return $interpretations[$number]['meaning'];
        }
        return "Chưa có diễn giải chi tiết cho ngày sinh {$number}.";
    }

    private static function getBirthDaySections($number)
    {
        $interpretations = self::getBirthDayInterpretationsData();
        if (isset($interpretations[$number])) {
            $data = $interpretations[$number];
            return [
                [
                    'title' => 'Đặc điểm nổi bật',
                    'content' => isset($data['traits']) ? implode(', ', $data['traits']) : ''
                ],
                [
                    'title' => 'Thách thức cần lưu ý',
                    'content' => isset($data['challenges']) ? implode(', ', $data['challenges']) : ''
                ],
                [
                    'title' => 'Nghề nghiệp phù hợp',
                    'content' => isset($data['careers']) ? implode(', ', $data['careers']) : ''
                ]
            ];
        }
        return [];
    }

    /**
     * Data đầy đủ diễn giải ngày sinh từ source code
     */
    private static function getBirthDayInterpretationsData()
    {
        return [
            1 => [
                'day' => 1,
                'title' => 'Lãnh đạo - Độc lập - Tiên phong',
                'meaning' => 'Số ngày sinh của bạn là 1, bạn sở hữu một món quà thiên phú ngay từ khi chào đời: đó là năng lượng lãnh đạo bẩm sinh, sự độc lập và óc sáng tạo đột phá. Từ thuở nhỏ, bạn có xu hướng tự khởi xướng – luôn chủ động, không chờ đợi hướng dẫn từ người khác. Tinh thần tiên phong trong bạn thể hiện rõ qua khả năng đưa ra ý tưởng mới, dám làm điều chưa ai làm và nhanh chóng thực thi với niềm tin mãnh liệt. Chính điều này khiến bạn dễ dàng tỏa sáng trong vai trò lãnh đạo, khởi nghiệp hay góp sức trong dự án mang tính đổi mới. Đây là một món quà cá nhân quý giá, giúp bạn tự tin đương đầu với thử thách, điều khiển định hướng bản thân và trở thành người tiên phong. Khi được phát huy đúng cách, món quà này sẽ giúp bạn gây ấn tượng và tạo dấu ấn mạnh mẽ trong công việc và cuộc sống.',
                'traits' => ['Lãnh đạo tự nhiên', 'Độc lập', 'Sáng tạo', 'Tiên phong', 'Quyết đoán', 'Tự tin'],
                'challenges' => ['Có thể quá cứng đầu', 'Khó hợp tác', 'Thiếu kiên nhẫn', 'Có xu hướng độc đoán'],
                'careers' => ['CEO/Giám đốc điều hành', 'Khởi nghiệp', 'Lãnh đạo nhóm', 'Nhà phát minh', 'Nhà thiết kế']
            ],

            2 => [
                'day' => 2,
                'title' => 'Kết nối - Đồng cảm - Hài hòa',
                'meaning' => 'Số ngày sinh của bạn là 2, bạn sở hữu một món quà tinh tế và quý giá ngay từ khi chào đời: đó là khả năng hòa giải, cảm nhận và kết nối độc đáo với mọi người xung quanh. Năng lượng "2" mang trong mình sự nhạy bén trong giao tiếp, sự cân bằng nội tâm và khả năng làm dịu những mâu thuẫn – một món quà tự nhiên mà bạn không cần học cũng có được. Từ tuổi nhỏ, bạn dễ dàng cảm nhận được cảm xúc của người khác và luôn có xu hướng hài hòa không khí, tạo nên sự an tâm và tin cậy trong nhóm. Đây thực sự là món quà cá nhân giúp bạn tỏa sáng khi đối diện với người khác, đặc biệt là trong các môi trường cần sự hợp tác, hỗ trợ và cảm thông. Sự kiên nhẫn và khéo léo là điểm mạnh khác giúp bạn ghi dấu ấn sâu sắc trong dự án nhóm, bạn là người lặng lẽ hỗ trợ, lắng nghe và đảm bảo mọi việc vận hành suôn sẻ. Là người sinh ra để thấu hiểu và kết nối, bạn luôn góp phần làm cho mọi người cảm thấy được lắng nghe và trân trọng. Khi năng lượng 2 được tôn vinh đúng cách – không bị chìm trong mong muốn làm hài lòng quá đáng – bạn sẽ là cầu nối tinh tế, đem lại sự "hòa hợp thần kỳ" nơi bạn hiện diện.',
                'traits' => ['Hòa giải tài ba', 'Cảm thông sâu sắc', 'Kết nối tự nhiên', 'Kiên nhẫn', 'Khéo léo', 'Đáng tin cậy'],
                'challenges' => ['Quá nhạy cảm', 'Dễ bị tổn thương', 'Thiếu tự tin', 'Muốn làm hài lòng mọi người'],
                'careers' => ['Tư vấn', 'Hòa giải', 'Giáo dục', 'Chăm sóc khách hàng', 'Nhân sự', 'Trị liệu']
            ],

            3 => [
                'day' => 3,
                'title' => 'Sáng tạo - Giao tiếp - Vui vẻ',
                'meaning' => 'Số ngày sinh của bạn là 3, bạn mang trong mình một món quà thật đặc biệt: đó là năng lượng sáng tạo, niềm vui sống và khả năng kết nối vui vẻ với mọi người. Từ khi còn nhỏ, bạn đã thể hiện tài năng ngôn ngữ – qua lời nói, viết lách hoặc biểu đạt nghệ thuật – giúp bạn lan tỏa cảm hứng và thu hút mọi người xung quanh. Bạn là người có thể thắp lên niềm vui và sự lạc quan chỉ bằng sự hiện diện của mình. Ở bạn toát ra thứ ánh sáng tự nhiên mà người khác cảm nhận ngay được – sự sáng tạo, nét hài hước và tình cảm chân thành của bạn trở thành giai điệu trong giao tiếp hàng ngày. Khả năng tự nhiên trong lĩnh vực nghệ thuật – viết, nói chuyện, biểu diễn, hoặc truyền cảm hứng thông qua giao tiếp – chính là món quà cá nhân khiến bạn tỏa sáng. Khi có cơ hội, bạn dễ dàng biến những ý tưởng thành lời, truyền cảm hứng cho người khác, và tạo nên sự kết nối sâu sắc & tích cực.',
                'traits' => ['Sáng tạo', 'Giao tiếp tốt', 'Hài hước', 'Lạc quan', 'Truyền cảm hứng', 'Nghệ thuật'],
                'challenges' => ['Dễ phân tâm', 'Thiếu kỷ luật', 'Không kiên trì', 'Quá lý tưởng'],
                'careers' => ['Nhà văn', 'Diễn viên', 'Nhà thiết kế', 'MC/Dẫn chương trình', 'Nghệ sĩ', 'Marketing']
            ],

            4 => [
                'day' => 4,
                'title' => 'Tổ chức - Kiên trì - Xây dựng',
                'meaning' => 'Số ngày sinh của bạn là 4, bạn mang trong mình một món quà quý giá ngay từ khi mới chào đời: đó là năng lực tổ chức, sự kiên nhẫn và trách nhiệm cực cao. Bạn là mẫu người xây móng cho mọi thứ, luôn chỉnh chu, cẩn trọng và đáng tin cậy ngay cả trong những việc nhỏ nhặt nhất. Đây không chỉ là tài năng cá nhân – mà là phẩm chất hình thành từ tinh thần và tính cách của bạn từ khi còn bé. Bạn dễ dàng trở thành người mà mọi người tìm đến khi cần "xử lý việc" – dù là sắp xếp dự án, lên kế hoạch chi tiết, hoặc duy trì hệ thống hoạt động ổn định. Khả năng quản lý chi tiết, làm việc có cấu trúc và hoàn thành nhiệm vụ đúng hạn giúp bạn tỏa sáng trong những vai trò cần sự thực tế và hiệu quả. Trong thực tế, bạn là "người xây nền" tuyệt vời: từ tổ chức sự kiện, quản lý dự án, đến duy trì tài chính hoặc thiết kế các hệ thống lâu dài – bạn đều thể hiện sự chuyên nghiệp và bản lĩnh. Đây chính là món quà cá nhân, giúp bạn tỏa sáng ở những vai trò cần tổ chức, kiên trì và tạo dựng kết quả bền vững.',
                'traits' => ['Tổ chức tốt', 'Kiên nhẫn', 'Trách nhiệm cao', 'Đáng tin cậy', 'Thực tế', 'Kỷ luật'],
                'challenges' => ['Quá cứng nhắc', 'Thiếu linh hoạt', 'Quá thận trọng', 'Sợ thay đổi'],
                'careers' => ['Quản lý dự án', 'Kế toán', 'Kỹ sư', 'Luật sư', 'Ngân hàng', 'Xây dựng']
            ],

            5 => [
                'day' => 5,
                'title' => 'Tự do - Thích nghi - Khám phá',
                'meaning' => 'Số ngày sinh của bạn là 5, bạn sở hữu một món quà quý giá từ khi vừa chào đời: khả năng thích nghi mạnh mẽ, tinh thần tự do và lòng ham khám phá. Con số này luôn gắn liền với tính linh hoạt, sự nhanh nhạy và một cái nhìn phóng khoáng, khiến bạn dễ dàng đối mặt với thay đổi và chinh phục môi trường mới. Bạn là người có tư duy nhạy bén, lanh lợi, cùng lúc giữ trong mình sự tò mò và khả năng giao tiếp sắc sảo. Bạn nhanh chóng nắm bắt tình huống và rất giỏi trong việc xử lý các tình huống bất ngờ – đó là món quà thiên phú giúp bạn tỏa sáng trong môi trường cần sự linh hoạt, từ du lịch, sáng tạo đến kinh doanh. Bẩm sinh bạn yêu thích sự đổi mới – dù là môi trường nghề nghiệp, sở thích cá nhân hay cách sống. Lòng ham tự do khiến bạn luôn cảm thấy hứng thú trong những hành trình, dự án đa chiều, nơi bạn có thể tự do điều chỉnh và thể hiện bản thân. Đây chính là món quà cá nhân giúp bạn ghi dấu ấn trong những lĩnh vực năng động cần tinh thần phiêu lưu và đổi mới liên tục.',
                'traits' => ['Linh hoạt', 'Thích nghi', 'Tự do', 'Phiêu lưu', 'Tò mò', 'Năng động'],
                'challenges' => ['Thiếu kiên trì', 'Không ổn định', 'Dễ chán', 'Thiếu cam kết'],
                'careers' => ['Du lịch', 'Bán hàng', 'Báo chí', 'Kinh doanh', 'Vận tải', 'Truyền thông']
            ],

            6 => [
                'day' => 6,
                'title' => 'Chăm sóc - Trách nhiệm - Hài hòa',
                'meaning' => 'Số ngày sinh của bạn là 6, bạn sở hữu một món quà đặc biệt từ khi mới chào đời: khả năng chăm sóc, trách nhiệm sâu sắc và tài tạo ra không gian hài hòa. Từ khi còn nhỏ, bạn đã toát lên năng lượng "người chở che" – luôn sẵn sàng hỗ trợ người khác, tạo ra cảm giác an toàn và dễ chịu trong bất cứ môi trường nào. Bạn có óc thẩm mỹ tự nhiên, tinh tế trong cách tạo ra vẻ đẹp – từ việc chăm chút không gian sống đến gu ăn uống, trang trí. Khả năng tạo cân bằng giữa trách nhiệm và cảm xúc khiến bạn nổi bật trong các vai trò cần sự phục vụ, như tư vấn, giảng dạy, cộng đồng hoặc chăm sóc gia đình. Đặc biệt, bạn là người giữ hòa bình – biết dung hòa mâu thuẫn, lắng nghe và điều phối cảm xúc một cách khéo léo. Khi ở bên bạn, người khác cảm thấy được thấu hiểu và an yên. Đây là món quà cá nhân quý báu, giúp bạn tỏa sáng trong những môi trường đòi hỏi sự chăm sóc, cam kết và tạo kết nối sâu sắc. Khi được thể hiện đúng, năng lực này không chỉ mang lại cảm giác thành tựu mà còn góp phần xây dựng cộng đồng và gia đình mạnh mẽ, vững chắc.',
                'traits' => ['Chăm sóc tốt', 'Trách nhiệm', 'Thẩm mỹ', 'Hòa bình', 'Cảm thông', 'Gia đình'],
                'challenges' => ['Quá lo lắng', 'Hy sinh bản thân', 'Khó từ chối', 'Áp lực từ trách nhiệm'],
                'careers' => ['Y tế', 'Giáo dục', 'Tư vấn gia đình', 'Thiết kế nội thất', 'Dịch vụ xã hội', 'Nghệ thuật']
            ],

            7 => [
                'day' => 7,
                'title' => 'Sâu sắc - Trực giác - Kiến thức',
                'meaning' => 'Số ngày sinh của bạn là 7, bạn mang trong mình một món quà đặc biệt từ khi mới chào đời: tư duy phân tích sâu, trực giác nhạy bén và khát khao khám phá ý nghĩa cuộc sống. Từ thuở nhỏ, bạn đã bộc lộ thiên hướng nội tâm – thích sự tĩnh lặng, suy tư, và thường tìm đến những chiều sâu của tri thức và triết lý. Bạn là người có khả năng phân tích tinh vi, giải quyết vấn đề một cách logic và độc lập. Món quà này giúp bạn tỏa sáng trong các lĩnh vực như nghiên cứu, khoa học, triết học, hoặc những nghề đòi hỏi sự trầm tĩnh và tư duy sâu sắc. Đồng thời, bạn còn sở hữu trực giác mạnh mẽ, dễ dàng nhận ra các chi tiết ẩn sâu, dẫn đến những nhận định sắc sảo mà nhiều người khó chạm tới. Khi bạn cho mình không gian để tĩnh lặng và khai thác năng lực này, bạn sẽ phát huy tối đa giá trị thiên phú – trở thành người khai sáng và dẫn dắt bằng trí tuệ, không bằng lời nói.',
                'traits' => ['Phân tích sâu', 'Trực giác mạnh', 'Tri thức', 'Nội tâm', 'Tĩnh lặng', 'Độc lập'],
                'challenges' => ['Cô lập bản thân', 'Quá phê phán', 'Khó gần', 'Thiếu giao tiếp'],
                'careers' => ['Nghiên cứu', 'Khoa học', 'Triết học', 'Tâm lý học', 'Viết lách', 'Công nghệ']
            ],

            8 => [
                'day' => 8,
                'title' => 'Lãnh đạo - Thực thi - Thịnh vượng',
                'meaning' => 'Số ngày sinh của bạn là 8, bạn bản năng sở hữu một món quà quyền lực: khả năng lãnh đạo tự nhiên, óc tổ chức chiến lược và năng lực thu hút tài chính. Bạn dễ dàng thấy cảm giác làm chủ ngay từ nhỏ – bạn biết cách đưa ra quyết định, tập hợp người cùng mục tiêu và theo đuổi các kế hoạch lớn với sự tự tin đáng nể. Bạn có tài năng xuất sắc trong việc làm chủ hệ thống, định hướng nguồn lực và thực hiện mục tiêu táo bạo. Năng lực này giúp bạn thành công trong các vị trí CEO, quản lý cấp cao hoặc kinh doanh lớn – nơi bạn có thể vận hành toàn diện và đạt được kết quả thực tế. Đặc biệt, khả năng đưa ra lựa chọn đúng đắn giữa sự phức tạp và nguồn lực khiến bạn dễ dàng tỏa sáng trong các lĩnh vực tài chính, quản trị hoặc kinh doanh. Tài năng bẩm sinh này là món quà cá nhân xuất sắc, mang đến cho bạn sự tự tin khi đảm nhận trọng trách, phát triển dự án lớn hoặc tạo ra ảnh hưởng đáng kể. Khi bạn khai thác đúng năng lượng 8 – vừa mạnh mẽ vừa trân trọng giá trị và cộng hưởng – bạn không chỉ gặt hái thành tựu bền vững mà còn góp phần tạo nên sự thịnh vượng chung.',
                'traits' => ['Lãnh đạo mạnh', 'Tổ chức chiến lược', 'Quyền lực', 'Tài chính', 'Quyết đoán', 'Thành công'],
                'challenges' => ['Quá tham quyền', 'Vật chất hóa', 'Áp lực cao', 'Thiếu cân bằng'],
                'careers' => ['CEO', 'Giám đốc', 'Ngân hàng đầu tư', 'Bất động sản', 'Luật sư', 'Chính trị']
            ],

            9 => [
                'day' => 9,
                'title' => 'Nhân đạo - Rộng lượng - Toàn cầu',
                'meaning' => 'Số ngày sinh của bạn là 9, bạn sở hữu một món quà bẩm sinh đặc biệt: lòng nhân hậu sâu sắc, tầm nhìn rộng lớn và khao khát cống hiến cho cộng đồng. Từ nhỏ, bạn đã dễ dàng thấu cảm, sẵn sàng giúp đỡ và để lại dấu ấn tích cực trong lòng người khác, thể hiện rõ năng lực quan tâm tới những giá trị lớn lao hơn bản thân. Bạn là người mang lý tưởng sống cao cả và thường thấy thôi thúc trong việc mang lại lợi ích cho xã hội. Sự rộng mở, trí tuệ và tinh thần phục vụ khiến bạn tỏa sáng trong các lĩnh vực như thiện nguyện, giảng dạy, nghệ thuật hoặc các công việc xã hội đầy ý nghĩa. Tài năng cá nhân này còn thể hiện ở sự kết nối sâu sắc với mọi người và tầm nhìn mang tính nhân loại. Bạn dễ dàng trở thành người truyền cảm hứng, sử dụng sự đồng cảm và trí tuệ để thúc đẩy những giá trị tích cực cho cộng đồng. Khi được sống đúng với thiên tài này, bạn không chỉ đạt được thành tựu cá nhân mà còn góp phần thay đổi cuộc sống của người khác theo hướng tốt đẹp hơn.',
                'traits' => ['Nhân đạo', 'Rộng lượng', 'Tầm nhìn xa', 'Cống hiến', 'Lý tưởng', 'Toàn cầu'],
                'challenges' => ['Quá lý tưởng', 'Dễ thất vọng', 'Bỏ bê bản thân', 'Thiếu thực tế'],
                'careers' => ['Giáo dục', 'Từ thiện', 'Nghệ thuật', 'Y tế', 'Môi trường', 'Nhân quyền']
            ],

            11 => [
                'day' => 11,
                'title' => 'Trực giác - Cảm hứng - Dẫn dắt tinh thần',
                'meaning' => 'Sinh vào ngày 11, bạn mang trong mình một món quà vô cùng đặc biệt: năng lực trực giác mạnh mẽ, khả năng truyền cảm hứng và tầm ảnh hưởng tinh thần sâu sắc. Đây là một trong những Master Number hiếm hoi — không bị rút gọn, bởi nó đã chứa sức mạnh kép của số 1 nhưng được nâng lên một tầng cao mới. Ngay từ khi còn nhỏ, bạn thường có khả năng cảm nhận trước mọi thứ, hiểu rõ cảm xúc, suy nghĩ hoặc hướng đi mà những người xung quanh mình đôi khi không nhận ra. Bạn thường được xem là người truyền cảm hứng, có khả năng chiếu sáng và dẫn lối cho người khác bằng tầm nhìn sâu sắc và cảm hứng mà bạn lan tỏa. Bên cạnh đó, bạn còn là cầu nối mạnh mẽ giữa trực giác và hành động, giữa tâm linh và thực tế. Món quà thiên phú này khiến bạn tỏa sáng trong các lĩnh vực như lãnh đạo tinh thần, giảng dạy, tư vấn hoặc bất kỳ đường đi nào liên quan đến thấu hiểu sâu sắc và truyền cảm hứng cho người khác. Tuy có sức mạnh lớn, nhưng Master 11 cũng đòi hỏi bạn phải học cách kiềm chế tính nhạy cảm quá mức để không bị choáng ngợp trước cảm xúc hoặc lo lắng. Khi bạn dung hòa được trực giác, cảm hứng và bản lĩnh cá nhân, bạn sẽ thực sự trở thành người dẫn đường, sử dụng món quà cá nhân để nâng cao và làm phong phú cuộc sống của người khác.',
                'traits' => ['Trực giác mạnh', 'Truyền cảm hứng', 'Nhạy cảm', 'Lãnh đạo tinh thần', 'Tầm nhìn sâu sắc', 'Dẫn dắt người khác'],
                'challenges' => ['Quá nhạy cảm', 'Dễ lo lắng', 'Choáng ngợp cảm xúc', 'Khó kiểm soát năng lượng'],
                'careers' => ['Lãnh đạo tinh thần', 'Giảng dạy', 'Tư vấn', 'Nghệ thuật', 'Tâm lý học', 'Trị liệu']
            ],

            22 => [
                'day' => 22,
                'title' => 'Master Builder - Tầm nhìn - Kiến tạo vĩ mô',
                'meaning' => 'Sinh vào ngày 22, bạn mang trong mình một món quà vô cùng đặc biệt và hiếm có: khả năng kết hợp giữa tầm nhìn siêu phàm và năng lực tổ chức thực tế để kiến tạo những kết quả có quy mô lớn. Master Number 22 được mệnh danh là "Master Builder" – người xây dựng vĩ mô, khả năng nhận diện cơ hội và biến chúng thành hiện thực bằng sự kiên trì và tổ chức tuyệt vời. Ngay từ lúc còn nhỏ, bạn đã bộc lộ phẩm chất lãnh đạo và tinh thần trách nhiệm mạnh mẽ. Bạn dễ dàng hình dung một hệ thống hoàn chỉnh, từ chiến lược đến thực thi, và có khả năng quản lý chi tiết hiệu quả. Đồng thời, trực giác tinh tế, charisma và óc nhìn xa trông rộng giúp bạn xây dựng nền tảng hướng tới mục tiêu lớn hơn bản thân, hướng đến lợi ích cộng đồng. Đây là món quà cá nhân đầy quyền năng, giúp bạn tỏa sáng trong các vai trò như nhà lãnh đạo tổ chức, nhà sáng lập, kiến trúc sư hệ thống xã hội hoặc người tạo dựng di sản lâu dài. Tuy nhiên, tiềm năng to lớn cũng đòi hỏi bạn phải kiên nhẫn "xây từ móng", vượt qua nỗi sợ lớn và biết nhẫn nại phát triển từng bước – điều tạo nên sự khác biệt thực sự giữa ước mơ và hiện thực.',
                'traits' => ['Master Builder', 'Tầm nhìn siêu phàm', 'Tổ chức tuyệt vời', 'Lãnh đạo mạnh mẽ', 'Kiến tạo quy mô lớn', 'Charisma'],
                'challenges' => ['Áp lực lớn', 'Mục tiêu quá cao', 'Nỗi sợ thất bại', 'Cần kiên nhẫn "xây từ móng"'],
                'careers' => ['CEO tổ chức lớn', 'Nhà sáng lập', 'Kiến trúc sư hệ thống', 'Lãnh đạo chính phủ', 'Nhà xây dựng di sản', 'Quản lý dự án khổng lồ']
            ]
        ];
    }

    private static function getExpressionInterpretation($number)
    {
        $interpretations = self::getExpressionInterpretationsData();
        if (isset($interpretations[$number])) {
            return $interpretations[$number]['fullText'];
        }
        return "Chưa có diễn giải chi tiết cho số tên {$number}.";
    }

    private static function getExpressionSections($number)
    {
        $interpretations = self::getExpressionInterpretationsData();
        if (isset($interpretations[$number])) {
            $data = $interpretations[$number];
            return [
                [
                    'title' => 'Lời khuyên',
                    'content' => isset($data['advice']) ? implode(' ', $data['advice']) : ''
                ]
            ];
        }
        return [];
    }

    /**
     * Data đầy đủ diễn giải số tên từ source code
     */
    public static function getExpressionInterpretationsData()
    {
        return [
            1 => [
                'number' => 1,
                'title' => 'Tiên phong - Lãnh đạo - Độc lập',
                'fullText' => 'Bạn có Số Tên là 1 – điều đó nói lên rằng bạn là người tiên phong, sinh ra để dẫn đầu và không ngại mở đường cho người khác. Trong bạn tồn tại một nguồn năng lượng mạnh mẽ của sự tự chủ, quyết đoán và tham vọng. Bạn luôn mong muốn được thể hiện bản thân theo cách riêng, và thường chọn những con đường ít người dám đi. Bạn là kiểu người không dễ bị ảnh hưởng bởi đám đông. Bạn có chính kiến rõ ràng, luôn muốn làm chủ tình huống và không thích bị kiểm soát. Điều này khiến bạn trở thành người phù hợp với vai trò lãnh đạo, hoặc ít nhất là người đi đầu trong những sáng kiến và kế hoạch mới. Với bạn, sự độc lập là rất quan trọng. Bạn thường tự mình lên ý tưởng, hành động nhanh và không ngần ngại chấp nhận rủi ro để đạt được điều mình muốn. Trong công việc hay các mối quan hệ, bạn thích sự rõ ràng, thẳng thắn và kết quả cụ thể. Tuy nhiên, điểm mạnh cũng có thể trở thành thử thách. Bạn dễ trở nên cứng đầu, khó tiếp thu ý kiến, hoặc có xu hướng tự cô lập vì cho rằng chỉ mình mới làm tốt. Đôi khi, bạn có thể cảm thấy mình "phải gồng lên" để duy trì vị trí dẫn đầu – trong khi điều bạn thực sự cần có thể là một sự đồng hành nhẹ nhàng, hiểu mình.',
                'advice' => ['Hãy học cách lắng nghe nhiều hơn và tin tưởng rằng sức mạnh không chỉ đến từ cá nhân – mà còn từ khả năng hợp tác và truyền cảm hứng cho người khác. Khi bạn kết hợp được sự tự tin với lòng khiêm tốn, bạn sẽ là người dẫn đầu thực thụ – không chỉ đi trước, mà còn đưa người khác cùng tiến xa.']
            ],
            2 => [
                'number' => 2,
                'title' => 'Hòa nhã - Hợp tác - Thấu hiểu',
                'fullText' => 'Bạn có Số Tên là 2 – điều này nói lên rằng bạn là người hòa nhã, tinh tế và luôn sẵn sàng mang lại sự hài hòa cho thế giới xung quanh. Bạn sở hữu một trực giác nhạy bén, khả năng thấu hiểu cảm xúc người khác và xu hướng tìm kiếm sự kết nối sâu sắc trong các mối quan hệ. Bạn không thích cạnh tranh gay gắt hay xung đột. Thay vào đó, bạn giỏi lắng nghe, thấu hiểu, và thường là "cầu nối cảm xúc" giữa những người không thể hiểu nhau. Bạn mang đến sự an ủi, hỗ trợ tinh thần và là người mà ai cũng muốn tâm sự mỗi khi cần một vòng tay đồng cảm. Bạn thường không quá tham vọng cá nhân – vì bạn coi trọng tập thể, sự hòa hợp và sự phát triển chung. Trong công việc, bạn là người cộng sự đáng tin cậy. Trong gia đình, bạn là người giữ gìn tình cảm. Trong tình yêu, bạn sâu sắc và đầy quan tâm. Tuy nhiên, đôi khi sự nhẹ nhàng của bạn cũng có thể khiến bạn do dự, khó nói "không", hoặc bị lợi dụng lòng tốt. Bạn có thể quá quan tâm đến cảm xúc người khác mà quên mất nhu cầu của chính mình.',
                'advice' => ['Hãy tin rằng lòng tốt không đồng nghĩa với việc phải làm hài lòng tất cả mọi người. Khi bạn biết giữ ranh giới, phát triển sự quyết đoán trong êm dịu, bạn sẽ thực sự tỏa sáng như một người hàn gắn, kết nối, và mang đến năng lượng chữa lành cho cả thế giới xung quanh bạn.']
            ],
            3 => [
                'number' => 3,
                'title' => 'Sáng tạo - Giao tiếp - Lạc quan',
                'fullText' => 'Bạn có Số Tên là 3 – điều này cho thấy bạn là người sáng tạo, lạc quan và có khả năng giao tiếp tuyệt vời. Bạn sở hữu một trí tưởng tượng phong phú và khả năng biểu đạt cảm xúc một cách tự nhiên, khiến bạn trở thành người truyền cảm hứng cho những người xung quanh. Bạn thường được biết đến với sự hài hước, duyên dáng và khả năng làm cho mọi người cảm thấy thoải mái. Bạn có thể tỏa sáng trong các lĩnh vực nghệ thuật như viết lách, âm nhạc, diễn xuất hoặc bất kỳ công việc nào đòi hỏi sự sáng tạo và giao tiếp. Khả năng kết nối và truyền đạt ý tưởng của bạn giúp bạn dễ dàng xây dựng các mối quan hệ xã hội và nghề nghiệp. Tuy nhiên, đôi khi bạn có thể gặp khó khăn trong việc duy trì sự tập trung và hoàn thành các dự án dài hạn. Sự đa dạng trong sở thích có thể khiến bạn dễ bị phân tâm và thiếu kiên nhẫn. Việc học cách tổ chức và cam kết với mục tiêu sẽ giúp bạn phát huy tối đa tiềm năng của mình.',
                'advice' => ['Hãy tận dụng khả năng sáng tạo và giao tiếp của mình để truyền cảm hứng cho người khác. Đồng thời, hãy rèn luyện tính kỷ luật và sự kiên trì để biến những ý tưởng tuyệt vời thành hiện thực. Khi bạn kết hợp được sự sáng tạo với sự tập trung, bạn sẽ đạt được thành công và mang lại niềm vui cho cả bản thân và những người xung quanh.']
            ],
            4 => [
                'number' => 4,
                'title' => 'Thực tế - Ổn định - Xây dựng',
                'fullText' => 'Bạn có Số Tên là 4 – điều này cho thấy bạn là người thực tế, đáng tin cậy và luôn hướng tới sự ổn định. Bạn sở hữu khả năng tổ chức, quản lý và xây dựng nền tảng vững chắc cho mọi việc bạn làm. Bạn là người chăm chỉ, kiên định và có trách nhiệm cao, luôn hoàn thành công việc một cách tỉ mỉ và chính xác. Bạn thích làm việc theo kế hoạch, có hệ thống và không ngại đối mặt với những thử thách để đạt được mục tiêu. Sự kiên nhẫn và khả năng tập trung giúp bạn vượt qua những trở ngại và xây dựng thành công lâu dài. Bạn là người mà người khác có thể tin cậy và dựa vào trong những lúc khó khăn. Tuy nhiên, đôi khi bạn có thể trở nên cứng nhắc, bảo thủ và khó thích nghi với những thay đổi. Sự tập trung quá mức vào chi tiết có thể khiến bạn bỏ lỡ bức tranh toàn cảnh và cơ hội phát triển. Bạn cũng có thể gặp khó khăn trong việc thể hiện cảm xúc và kết nối với người khác ở mức độ sâu sắc hơn.',
                'advice' => ['Hãy học cách linh hoạt hơn và cởi mở với những ý tưởng mới. Dành thời gian để thư giãn, tận hưởng cuộc sống và kết nối với cảm xúc của bản thân sẽ giúp bạn cân bằng giữa công việc và cuộc sống cá nhân. Khi bạn kết hợp được sự ổn định với sự linh hoạt, bạn sẽ xây dựng được một cuộc sống bền vững và trọn vẹn.']
            ],
            5 => [
                'number' => 5,
                'title' => 'Tự do - Phiêu lưu - Linh hoạt',
                'fullText' => 'Bạn có Số Tên là 5 – điều này cho thấy bạn là người yêu tự do, thích phiêu lưu và luôn tìm kiếm những trải nghiệm mới mẻ. Bạn sở hữu tinh thần cởi mở, linh hoạt và khả năng thích nghi cao với mọi hoàn cảnh. Bạn không ngại thay đổi và thường bị thu hút bởi những điều mới lạ, khác biệt. Bạn là người sống động, hài hước và có khả năng giao tiếp tuyệt vời. Sự tò mò và ham học hỏi khiến bạn luôn muốn khám phá thế giới xung quanh. Bạn thích sự đa dạng và không chịu được sự nhàm chán hay ràng buộc quá lâu. Tuy nhiên, đôi khi bạn có thể trở nên thiếu kiên nhẫn, dễ bị phân tâm và khó hoàn thành công việc đến cùng. Sự yêu thích tự do có thể khiến bạn tránh né trách nhiệm hoặc cam kết lâu dài. Bạn cũng cần cẩn trọng với xu hướng tìm kiếm cảm giác mạnh hoặc thay đổi liên tục, dẫn đến thiếu ổn định trong cuộc sống.',
                'advice' => ['Hãy học cách cân bằng giữa sự tự do và trách nhiệm. Tập trung vào những mục tiêu cụ thể và kiên trì theo đuổi đến cùng sẽ giúp bạn phát huy tối đa tiềm năng của mình. Đồng thời, hãy tận dụng khả năng giao tiếp và thích nghi để xây dựng các mối quan hệ bền vững và thành công trong sự nghiệp.']
            ],
            6 => [
                'number' => 6,
                'title' => 'Yêu thương - Chăm sóc - Trách nhiệm',
                'fullText' => 'Bạn có Số Tên là 6, bạn là người giàu lòng yêu thương, luôn sẵn sàng chăm sóc và hỗ trợ người khác. Bạn có khả năng tạo ra môi trường ấm áp, hài hòa và là chỗ dựa vững chắc cho gia đình và bạn bè. Bạn coi trọng trách nhiệm và thường đặt nhu cầu của người khác lên trên bản thân. Bạn có năng khiếu trong các lĩnh vực nghệ thuật, thiết kế và có khả năng sáng tạo trong việc làm đẹp không gian sống. Bạn cũng là người có trực giác tốt, dễ dàng cảm nhận và thấu hiểu cảm xúc của người khác. Tuy nhiên, đôi khi bạn có thể trở nên quá bảo bọc, dẫn đến việc can thiệp quá mức vào cuộc sống của người khác. Bạn cũng cần chú ý đến việc chăm sóc bản thân và không để bản thân bị kiệt sức vì lo lắng cho người khác.',
                'advice' => ['Hãy học cách cân bằng giữa việc chăm sóc người khác và chăm sóc bản thân. Đặt ra ranh giới rõ ràng sẽ giúp bạn duy trì mối quan hệ lành mạnh và tránh bị kiệt sức. Sự yêu thương và quan tâm của bạn là món quà quý giá, nhưng hãy nhớ rằng bạn cũng xứng đáng nhận được sự chăm sóc và yêu thương từ chính mình.']
            ],
            7 => [
                'number' => 7,
                'title' => 'Sâu sắc - Trí tuệ - Trực giác',
                'fullText' => 'Bạn có Số Tên là 7, bạn là người sâu sắc, trí tuệ và luôn khao khát tìm hiểu những bí ẩn của cuộc sống. Bạn sở hữu tư duy phân tích sắc bén, khả năng quan sát tinh tế và một trực giác mạnh mẽ. Bạn thường bị thu hút bởi các lĩnh vực như triết học, khoa học, tâm linh hoặc bất kỳ điều gì đòi hỏi sự suy ngẫm và khám phá sâu sắc. Bạn thích dành thời gian một mình để suy ngẫm và nạp lại năng lượng. Sự yên tĩnh giúp bạn kết nối với nội tâm và khám phá những tầng sâu của bản thân. Bạn có khả năng tập trung cao độ và thường đạt được sự hiểu biết sâu sắc trong lĩnh vực mà bạn quan tâm. Tuy nhiên, đôi khi bạn có thể trở nên quá khép kín hoặc xa cách với người khác. Sự tập trung vào thế giới nội tâm có thể khiến bạn bỏ lỡ những kết nối xã hội quan trọng. Bạn cũng có thể dễ bị cuốn vào việc phân tích quá mức, dẫn đến sự do dự hoặc thiếu quyết đoán.',
                'advice' => ['Hãy học cách cân bằng giữa thời gian dành cho bản thân và việc kết nối với người khác. Chia sẻ những hiểu biết và trí tuệ của bạn có thể mang lại giá trị lớn cho cộng đồng. Đồng thời, hãy tin tưởng vào trực giác của mình và đừng ngại mở lòng để đón nhận những trải nghiệm mới.']
            ],
            8 => [
                'number' => 8,
                'title' => 'Lãnh đạo - Thành công - Quyền lực',
                'fullText' => 'Bạn có Số Tên là 8, bạn là người có khả năng lãnh đạo bẩm sinh, đầy tham vọng và luôn hướng tới thành công trong lĩnh vực vật chất. Bạn sở hữu tư duy chiến lược, khả năng tổ chức và quản lý xuất sắc, cùng với sự quyết đoán và kiên định trong hành động. Bạn không ngại đối mặt với thử thách và luôn sẵn sàng vượt qua mọi trở ngại để đạt được mục tiêu của mình. Bạn có khả năng nhìn nhận tổng thể, đánh giá rủi ro và đưa ra quyết định một cách chính xác. Sự tự tin và khả năng kiểm soát tình huống giúp bạn dễ dàng thu hút sự tin tưởng từ người khác và dẫn dắt họ theo hướng bạn mong muốn. Bạn thường được đánh giá cao trong các lĩnh vực như kinh doanh, tài chính, quản lý hoặc bất kỳ vị trí nào đòi hỏi sự lãnh đạo và trách nhiệm cao. Tuy nhiên, đôi khi bạn có thể trở nên quá cứng nhắc, kiểm soát và đặt nặng vấn đề vật chất, dẫn đến việc bỏ qua các khía cạnh cảm xúc và tinh thần trong cuộc sống. Sự tập trung quá mức vào thành công có thể khiến bạn trở nên xa cách với người thân và bạn bè. Bạn cũng cần lưu ý đến việc duy trì sự cân bằng giữa công việc và cuộc sống cá nhân để tránh tình trạng kiệt sức hoặc mất phương hướng.',
                'advice' => ['Hãy học cách lắng nghe và thấu hiểu cảm xúc của bản thân và người khác. Việc kết hợp giữa sự quyết đoán và lòng nhân ái sẽ giúp bạn trở thành một nhà lãnh đạo toàn diện, không chỉ đạt được thành công về mặt vật chất mà còn xây dựng được các mối quan hệ bền vững và ý nghĩa. Đồng thời, hãy nhớ rằng thành công thực sự không chỉ được đo bằng tài sản hay địa vị, mà còn bởi sự hài lòng và hạnh phúc trong cuộc sống.']
            ],
            9 => [
                'number' => 9,
                'title' => 'Nhân ái - Lý tưởng - Phục vụ',
                'fullText' => 'Bạn có Số Tên là 9 – điều này cho thấy bạn là người sâu sắc, giàu lòng nhân ái và luôn mang trong mình khát vọng giúp đỡ thế giới. Bạn nhìn cuộc sống với một trái tim rộng mở và tâm hồn lý tưởng. Với bạn, việc sống có ý nghĩa không chỉ là thành công cá nhân, mà là đóng góp cho cộng đồng và nâng cao chất lượng cuộc sống của người khác. Bạn là người của lòng vị tha, bao dung và giàu cảm xúc. Bạn dễ đồng cảm, dễ xúc động và thường mang trong mình một nỗi niềm rất nhân văn. Nhiều người tìm đến bạn như một điểm tựa tinh thần, vì bạn biết lắng nghe, thấu hiểu và truyền cảm hứng. Bạn có thiên hướng nghệ thuật hoặc triết lý, và thường gắn bó với các hoạt động mang tính phục vụ cộng đồng, giáo dục hoặc chữa lành. Tuy nhiên, bạn cần lưu ý – đôi khi lòng tốt của bạn có thể bị lợi dụng, và bạn có xu hướng ôm đồm, quên mất việc chăm sóc cho chính mình. Bạn cũng dễ lý tưởng hóa mọi thứ, dẫn đến thất vọng nếu người khác không hành xử theo kỳ vọng của bạn.',
                'advice' => ['Hãy nhớ rằng, lòng nhân ái cần đi kèm với trí tuệ. Khi bạn biết đặt ranh giới lành mạnh, bạn không chỉ bảo vệ được nguồn năng lượng tích cực của mình, mà còn có thể giúp đỡ người khác một cách sâu sắc và bền vững hơn. Đừng ngần ngại tỏa sáng – vì bạn là ánh sáng ấm áp của lòng trắc ẩn và sự khai sáng.']
            ],
            11 => [
                'number' => 11,
                'title' => 'Master Number - Trực giác - Truyền cảm hứng',
                'fullText' => 'Bạn có Số Tên là 11 – một con số "Master Number" đặc biệt, thể hiện bạn mang trong mình sứ mệnh tinh thần sâu sắc. Bạn không chỉ sống cho riêng mình, mà còn được sinh ra để truyền cảm hứng, chữa lành và dẫn dắt người khác qua những tầng nhận thức cao hơn. Trực giác của bạn nhạy bén, cảm xúc sâu sắc và luôn có những suy tư vượt ra ngoài khuôn khổ thông thường. Bạn thường cảm thấy bản thân khác biệt – không phải theo cách tách biệt, mà là như thể bạn đang kết nối với điều gì đó lớn hơn: linh hồn, vũ trụ hoặc chân lý nào đó chưa được nói thành lời. Khi bạn sống đúng với tiềm năng của mình, bạn có thể trở thành người khai sáng, người cố vấn tâm linh, hoặc người truyền cảm hứng cho cộng đồng. Tuy nhiên, bạn cũng có thể trải qua nhiều mâu thuẫn nội tâm, cảm giác không thuộc về hoặc bị choáng ngợp bởi chính trực giác của mình. Bạn có thể dễ bị tổn thương vì cảm nhận quá nhiều, hoặc nghi ngờ sứ mệnh của bản thân vì cuộc sống thực tế đôi khi không "đồng điệu" với chiều sâu bên trong bạn.',
                'advice' => ['Hãy học cách kết nối với bản thân qua thiền định, viết lách, nghệ thuật hoặc thời gian trong thiên nhiên. Khi bạn giữ được sự cân bằng giữa cảm xúc – lý trí – tâm linh, bạn sẽ trở thành "ngọn đèn" soi sáng cho chính mình và cho những ai đang tìm đường trong bóng tối.']
            ],
            22 => [
                'number' => 22,
                'title' => 'Master Builder - Tầm nhìn - Kiến tạo',
                'fullText' => 'Bạn có Số Tên là 22 – một trong những Master Number quyền lực nhất trong Thần số học. Đây là con số của những người được sinh ra để xây dựng những điều vĩ đại, mang tầm vóc xã hội và tạo nên giá trị lâu dài cho nhân loại. Bạn không chỉ là người mơ ước, mà là người hành động để biến ước mơ thành hiện thực. Bạn có năng lực tổ chức vượt trội, óc chiến lược, và một tâm hồn đầy trách nhiệm. Bạn kết hợp được sự thực tế của số 4 với tầm nhìn rộng lớn của các con số linh thiêng. Sự nghiệp, cộng đồng và các dự án dài hạn là nơi bạn phát huy tối đa thế mạnh của mình. Bạn là người không sợ thử thách – vì bạn biết mình đến để kiến tạo, cải tiến và đóng góp thực chất. Tuy nhiên, đi kèm với tiềm năng vĩ đại là áp lực nội tâm rất lớn. Bạn có thể cảm thấy gánh nặng từ chính kỳ vọng của bản thân, hoặc bị phân tâm giữa lý tưởng và thực tế. Có lúc bạn dễ rơi vào trạng thái hoài nghi, lo lắng rằng mình "chưa đủ tốt" hoặc "chưa làm được điều xứng đáng với con số 22".',
                'advice' => ['Hãy tin rằng bạn không cần phải làm điều gì "vĩ đại" ngay lập tức. Điều bạn cần là bắt đầu từ hành động nhỏ với sự cam kết lớn. Khi bạn xây dựng từng viên gạch với tình yêu và sự bền bỉ, bạn sẽ thực sự trở thành người kiến tạo nên những giá trị có sức ảnh hưởng sâu xa. Hãy giữ vững niềm tin – bạn sinh ra để thay đổi thế giới.']
            ]
        ];
    }

    private static function getSoulUrgeInterpretation($number) { return "Giải thích số linh hồn {$number}"; }
    private static function getSoulUrgeSections($number) { return []; }

    private static function getPersonalityInterpretation($number) { return "Giải thích số tính cách {$number}"; }
    private static function getPersonalitySections($number) { return []; }

    private static function getBirthChartInterpretation($frequencies, $missing, $dominant) { return "Giải thích biểu đồ ngày sinh"; }
    private static function getBirthChartSections($frequencies, $missing, $dominant) { return []; }

    private static function getArrowInterpretation($arrowName, $isPresent)
    {
        $interpretations = [
            'arrow_of_planning' => [
                'present' => [
                    'title' => 'Mũi Tên Kế Hoạch (1-2-3)',
                    'description' => 'Bạn là người có tư duy logic, kỷ luật và khả năng tổ chức bẩm sinh. Việc lên kế hoạch, sắp xếp công việc, quản lý thời gian với bạn là điều hết sức tự nhiên.',
                    'strengths' => ['Tư duy logic', 'Kỷ luật cao', 'Tổ chức giỏi', 'Quản lý thời gian tốt'],
                    'advice' => 'Hãy tận dụng khả năng tổ chức để dẫn dắt và hướng dẫn người khác. Bạn có thể trở thành quản lý xuất sắc.'
                ],
                'missing' => [
                    'title' => 'Thiếu Mũi Tên Kế Hoạch (1-2-3)',
                    'description' => 'Bạn có thể gặp khó khăn trong việc lập kế hoạch, tổ chức và duy trì kỷ luật. Thường hành động theo cảm hứng.',
                    'challenges' => ['Thiếu tổ chức', 'Kém kế hoạch', 'Thiếu kỷ luật'],
                    'advice' => 'Hãy bắt đầu với thói quen nhỏ như lập danh sách việc cần làm. Học từ những người có kỹ năng tổ chức tốt.'
                ]
            ],
            'arrow_of_will' => [
                'present' => [
                    'title' => 'Mũi Tên Ý Chí (4-5-6)',
                    'description' => 'Bạn có ý chí mạnh mẽ và khả năng tự kiểm soát tốt. Có thể duy trì kỷ luật và theo đuổi mục tiêu một cách bền bỉ.',
                    'strengths' => ['Ý chí mạnh', 'Tự kiểm soát', 'Kỷ luật cao', 'Bền bỉ'],
                    'advice' => 'Hãy sử dụng ý chí mạnh mẽ này để vượt qua mọi thử thách và đạt được thành công.'
                ],
                'missing' => [
                    'title' => 'Thiếu Mũi Tên Ý Chí (4-5-6)',
                    'description' => 'Có thể thiếu ý chí hoặc khó duy trì kỷ luật. Thường dễ bị phân tâm hoặc bỏ cuộc giữa chừng.',
                    'challenges' => ['Thiếu ý chí', 'Khó tự kiểm soát', 'Dễ bỏ cuộc'],
                    'advice' => 'Hãy xây dựng thói quen tốt từng ngày và tìm động lực mạnh mẽ để duy trì ý chí.'
                ]
            ],
            'arrow_of_action' => [
                'present' => [
                    'title' => 'Mũi Tên Hành Động (7-8-9)',
                    'description' => 'Bạn là người sống năng động, nhiệt huyết và luôn sẵn sàng hành động. Khi có ý tưởng, bạn không ngồi chờ đợi mà bắt tay vào làm ngay.',
                    'strengths' => ['Năng động', 'Quyết đoán', 'Chủ động', 'Hành động nhanh'],
                    'advice' => 'Hãy kết hợp tốc độ với sự suy xét. Đôi khi chậm lại một chút để tính toán sẽ giúp bạn tiến xa hơn.'
                ],
                'missing' => [
                    'title' => 'Thiếu Mũi Tên Hành Động (7-8-9)',
                    'description' => 'Có thể gặp khó khăn trong việc duy trì động lực và sự chủ động. Thường trì hoãn, thiếu quyết đoán.',
                    'challenges' => ['Trì hoãn', 'Thiếu quyết đoán', 'Chậm chạp'],
                    'advice' => 'Hãy thiết lập mục tiêu nhỏ và thực tế. Tham gia hoạt động nhóm để tăng cường động lực hành động.'
                ]
            ],
            'arrow_of_practical' => [
                'present' => [
                    'title' => 'Mũi Tên Thực Tế (1-4-7)',
                    'description' => 'Bạn là người có tư duy thực tế, sống có nguyên tắc và chú trọng vào hành động cụ thể. Mọi việc bạn làm đều từ nền tảng chắc chắn.',
                    'strengths' => ['Thực tế', 'Có nguyên tắc', 'Chắc chắn', 'Đáng tin cậy'],
                    'advice' => 'Hãy mở lòng đón nhận cả yếu tố cảm xúc và sáng tạo để phát triển toàn diện hơn.'
                ],
                'missing' => [
                    'title' => 'Thiếu Mũi Tên Thực Tế (1-4-7)',
                    'description' => 'Có thể gặp khó khăn trong việc áp dụng kiến thức vào thực tiễn. Thường sống trong thế giới tưởng tượng.',
                    'challenges' => ['Thiếu thực tế', 'Tưởng tượng quá', 'Khó áp dụng'],
                    'advice' => 'Hãy tham gia các hoạt động thực tế như làm vườn, nấu ăn để tăng cường kết nối với thế giới thực.'
                ]
            ],
            'arrow_of_emotional' => [
                'present' => [
                    'title' => 'Mũi Tên Cảm Xúc (2-5-8)',
                    'description' => 'Bạn có khả năng cảm nhận và hiểu được cảm xúc của bản thân và người khác. Rất nhạy cảm và đồng cảm.',
                    'strengths' => ['Nhạy cảm cao', 'Đồng cảm', 'Hiểu người', 'Cảm xúc phong phú'],
                    'advice' => 'Hãy sử dụng trực giác và sự nhạy cảm để kết nối với mọi người xung quanh.'
                ],
                'missing' => [
                    'title' => 'Thiếu Mũi Tên Cảm Xúc (2-5-8)',
                    'description' => 'Có thể gặp khó khăn trong việc bày tỏ cảm xúc hoặc hiểu cảm xúc của người khác. Thường lý trí hơn cảm xúc.',
                    'challenges' => ['Khô khan cảm xúc', 'Khó hiểu người', 'Thiếu đồng cảm'],
                    'advice' => 'Hãy học cách bày tỏ cảm xúc tự nhiên và lắng nghe người khác nhiều hơn.'
                ]
            ],
            'arrow_of_intelligence' => [
                'present' => [
                    'title' => 'Mũi Tên Trí Tuệ (3-6-9)',
                    'description' => 'Bạn sở hữu trí tuệ sắc bén và khả năng tư duy logic xuất sắc. Có thể hiểu và phân tích vấn đề một cách sâu sắc.',
                    'strengths' => ['Trí tuệ cao', 'Tư duy logic', 'Phân tích tốt', 'Thông minh'],
                    'advice' => 'Hãy sử dụng trí tuệ để giải quyết những vấn đề phức tạp. Bạn có thể trở thành cố vấn tuyệt vời.'
                ],
                'missing' => [
                    'title' => 'Thiếu Mũi Tên Trí Tuệ (3-6-9)',
                    'description' => 'Có thể gặp khó khăn trong việc tư duy logic hoặc phân tích vấn đề. Thường dựa vào cảm xúc nhiều hơn logic.',
                    'challenges' => ['Tư duy chậm', 'Khó phân tích', 'Dựa vào cảm xúc'],
                    'advice' => 'Hãy rèn luyện kỹ năng tư duy logic thông qua đọc sách và giải quyết vấn đề.'
                ]
            ],
            'arrow_of_determination' => [
                'present' => [
                    'title' => 'Mũi Tên Quyết Tâm (1-5-9)',
                    'description' => 'Bạn sở hữu sức mạnh quyết tâm phi thường. Khi đã đặt mục tiêu, bạn sẽ không ngừng nỗ lực đến khi đạt được.',
                    'strengths' => ['Quyết tâm cao', 'Kiên định', 'Tập trung', 'Không bỏ cuộc'],
                    'advice' => 'Hãy đặt ra những mục tiêu rõ ràng và thực tế. Sức mạnh quyết tâm của bạn là vũ khí mạnh nhất.'
                ],
                'missing' => [
                    'title' => 'Thiếu Mũi Tên Quyết Tâm (1-5-9)',
                    'description' => 'Bạn có thể gặp khó khăn trong việc duy trì quyết tâm và kiên trì với mục tiêu dài hạn.',
                    'challenges' => ['Thiếu kiên trì', 'Dễ bỏ cuộc', 'Khó tập trung lâu'],
                    'advice' => 'Hãy chia nhỏ mục tiêu lớn thành các bước nhỏ. Tìm người đồng hành để duy trì động lực.'
                ]
            ],
            'arrow_of_spiritual' => [
                'present' => [
                    'title' => 'Mũi Tên Tâm Linh (3-5-7)',
                    'description' => 'Bạn có khả năng kết nối với thế giới tâm linh và có trực giác sâu sắc. Thường quan tâm đến ý nghĩa sâu xa của cuộc sống.',
                    'strengths' => ['Trực giác mạnh', 'Tâm linh cao', 'Hiểu biết sâu', 'Khôn ngoan'],
                    'advice' => 'Hãy tin vào trực giác của mình và tìm kiếm ý nghĩa sâu xa trong mọi việc.'
                ],
                'missing' => [
                    'title' => 'Thiếu Mũi Tên Tâm Linh (3-5-7)',
                    'description' => 'Có thể thiếu kết nối tâm linh hoặc trực giác không mạnh. Thường tập trung vào vật chất hơn tâm linh.',
                    'challenges' => ['Thiếu trực giác', 'Không tâm linh', 'Quá vật chất'],
                    'advice' => 'Hãy dành thời gian để thiền định, suy ngẫm và kết nối với bản thân sâu hơn.'
                ]
            ]
        ];

        $type = $isPresent ? 'present' : 'missing';
        $arrowKey = str_replace('missing_', '', $arrowName);

        return $interpretations[$arrowKey][$type] ?? [
            'title' => 'Mũi tên không xác định',
            'description' => 'Chưa có thông tin về mũi tên này.'
        ];
    }
    private static function getArrowsInterpretation($arrows)
    {
        if (empty($arrows)) {
            return 'Biểu đồ ngày sinh của bạn chưa thể hiện rõ các mũi tên cá tính. Điều này có nghĩa là bạn có tính cách cân bằng và linh hoạt.';
        }

        $presentArrows = array_filter($arrows, function($arrow) {
            return $arrow['type'] === 'present';
        });

        $missingArrows = array_filter($arrows, function($arrow) {
            return $arrow['type'] === 'missing';
        });

        $interpretation = '';

        if (!empty($presentArrows)) {
            $interpretation .= 'Bạn sở hữu ' . count($presentArrows) . ' mũi tên cá tính mạnh mẽ, thể hiện những khả năng đặc biệt: ';
            $arrowNames = array_map(function($arrow) {
                return $arrow['interpretation']['title'];
            }, $presentArrows);
            $interpretation .= implode(', ', $arrowNames) . '. ';
        }

        if (!empty($missingArrows)) {
            $interpretation .= 'Đồng thời, bạn cũng cần chú ý đến ' . count($missingArrows) . ' lĩnh vực cần phát triển thêm để hoàn thiện bản thân. ';
        }

        $interpretation .= 'Hãy tận dụng những điểm mạnh và cải thiện những điểm yếu để đạt được sự cân bằng trong cuộc sống.';

        return $interpretation;
    }
    private static function getArrowsSections($arrows)
    {
        if (empty($arrows)) {
            return [
                [
                    'title' => '🎯 Tổng quan',
                    'content' => 'Bạn có tính cách cân bằng, không có mũi tên nào đặc biệt nổi bật. Điều này cho thấy sự linh hoạt và khả năng thích ứng tốt.'
                ]
            ];
        }

        $sections = [];

        $presentArrows = array_filter($arrows, function($arrow) {
            return $arrow['type'] === 'present';
        });

        $missingArrows = array_filter($arrows, function($arrow) {
            return $arrow['type'] === 'missing';
        });

        if (!empty($presentArrows)) {
            $sections[] = [
                'title' => '🌟 Điểm Mạnh - Mũi Tên Sở Hữu',
                'content' => 'Bạn sở hữu những mũi tên cá tính mạnh mẽ sau:'
            ];

            foreach ($presentArrows as $arrow) {
                $sections[] = [
                    'title' => '▶️ ' . $arrow['interpretation']['title'],
                    'content' => $arrow['interpretation']['description'] . '\n\n' .
                                '✨ Điểm mạnh: ' . implode(', ', $arrow['interpretation']['strengths']) . '\n\n' .
                                '💡 Lời khuyên: ' . $arrow['interpretation']['advice']
                ];
            }
        }

        if (!empty($missingArrows)) {
            $sections[] = [
                'title' => '⚠️ Cần Phát Triển - Mũi Tên Thiếu',
                'content' => 'Những lĩnh vực bạn cần chú ý phát triển:'
            ];

            foreach ($missingArrows as $arrow) {
                $sections[] = [
                    'title' => '📍 ' . $arrow['interpretation']['title'],
                    'content' => $arrow['interpretation']['description'] . '\n\n' .
                                '⚡ Thách thức: ' . implode(', ', $arrow['interpretation']['challenges']) . '\n\n' .
                                '🎯 Cách cải thiện: ' . $arrow['interpretation']['advice']
                ];
            }
        }

        $sections[] = [
            'title' => '🌈 Lời Khuyên Tổng Hợp',
            'content' => 'Mỗi mũi tên trong biểu đồ số học đều mang một ý nghĩa riêng. Hãy tận dụng những điểm mạnh bạn đang có và kiên trì phát triển những lĩnh vực còn yếu. Sự cân bằng giữa tất cả các mũi tên sẽ giúp bạn đạt được thành công và hạnh phúc trong cuộc sống.'
        ];

        return $sections;
    }

    private static function getAttitudeInterpretation($number) { return "Giải thích số thái độ {$number}"; }
    private static function getAttitudeSections($number) { return []; }

    private static function getMaturityInterpretation($number) { return "Giải thích số trưởng thành {$number}"; }
    private static function getMaturitySections($number) { return []; }

    private static function getPersonalYearInterpretation($number) { return "Giải thích năm cá nhân {$number}"; }
    private static function getPersonalYearSections($number) { return []; }

    // ========================
    // HELPER METHODS FOR NEW FEATURES
    // ========================

    private static function getNineYearPhase($personalYear)
    {
        $phases = [
            1 => 'Khởi đầu mới',
            2 => 'Hợp tác và kiên nhẫn',
            3 => 'Sáng tạo và giao tiếp',
            4 => 'Xây dựng nền tảng',
            5 => 'Thay đổi và tự do',
            6 => 'Trách nhiệm và gia đình',
            7 => 'Tự suy ngẫm',
            8 => 'Thành công vật chất',
            9 => 'Hoàn thành và giải phóng'
        ];
        return $phases[$personalYear] ?? 'Không xác định';
    }

    private static function getCurrentPhase($cycles)
    {
        $currentYear = date('Y');
        foreach ($cycles as $cycle) {
            if ($cycle['year'] == $currentYear) {
                return $cycle;
            }
        }
        return null;
    }

    private static function getPinnacleInterpretation($number, $pinnacle)
    {
        $interpretations = [
            1 => [
                1 => 'Giai đoạn học cách độc lập và tự tin.',
                2 => 'Thời kỳ phát triển khả năng lãnh đạo.',
                3 => 'Giai đoạn khẳng định bản thân và sáng tạo.',
                4 => 'Thời kỳ trở thành người tiên phong trong lĩnh vực của mình.'
            ],
            2 => [
                1 => 'Giai đoạn học cách hợp tác và nhạy cảm.',
                2 => 'Thời kỳ phát triển kỹ năng giao tiếp.',
                3 => 'Giai đoạn xây dựng mối quan hệ bền vững.',
                4 => 'Thời kỳ trở thành người hòa giải và cố vấn.'
            ],
            // Thêm các số khác...
        ];
        return $interpretations[$number][$pinnacle] ?? "Giải thích đỉnh cao {$pinnacle} số {$number}";
    }

    private static function calculateCommunicationAbility($frequencies)
    {
        // Chữ cái liên quan đến giao tiếp: A, E, I, O, U, C, G, L, S
        $commLetters = ['A', 'E', 'I', 'O', 'U', 'C', 'G', 'L', 'S'];
        $total = 0;
        foreach ($commLetters as $letter) {
            $total += $frequencies[$letter] ?? 0;
        }
        return [
            'score' => min(10, $total),
            'level' => self::getAbilityLevel($total),
            'interpretation' => 'Khả năng giao tiếp và biểu đạt ý tưởng.'
        ];
    }

    private static function calculateCreativityAbility($frequencies)
    {
        // Chữ cái liên quan đến sáng tạo: C, F, I, L, P, T, V, Y
        $creativeLetters = ['C', 'F', 'I', 'L', 'P', 'T', 'V', 'Y'];
        $total = 0;
        foreach ($creativeLetters as $letter) {
            $total += $frequencies[$letter] ?? 0;
        }
        return [
            'score' => min(10, $total),
            'level' => self::getAbilityLevel($total),
            'interpretation' => 'Khả năng sáng tạo và đổi mới.'
        ];
    }

    private static function calculateOrganizationAbility($frequencies)
    {
        // Chữ cái liên quan đến tổ chức: D, H, M, Q, R, U, X, Z
        $orgLetters = ['D', 'H', 'M', 'Q', 'R', 'U', 'X', 'Z'];
        $total = 0;
        foreach ($orgLetters as $letter) {
            $total += $frequencies[$letter] ?? 0;
        }
        return [
            'score' => min(10, $total),
            'level' => self::getAbilityLevel($total),
            'interpretation' => 'Khả năng tổ chức và quản lý.'
        ];
    }

    private static function calculateIntuitionAbility($frequencies)
    {
        // Chữ cái liên quan đến trực giác: B, J, K, N, O, W
        $intuitionLetters = ['B', 'J', 'K', 'N', 'O', 'W'];
        $total = 0;
        foreach ($intuitionLetters as $letter) {
            $total += $frequencies[$letter] ?? 0;
        }
        return [
            'score' => min(10, $total),
            'level' => self::getAbilityLevel($total),
            'interpretation' => 'Khả năng trực giác và thấu hiểu.'
        ];
    }

    private static function getAbilityLevel($score)
    {
        if ($score >= 7) return 'Rất cao';
        if ($score >= 5) return 'Cao';
        if ($score >= 3) return 'Trung bình';
        if ($score >= 1) return 'Thấp';
        return 'Rất thấp';
    }

    private static function getDominantAbility($abilities)
    {
        $max = 0;
        $dominant = 'communication';
        foreach ($abilities as $type => $data) {
            if ($data['score'] > $max) {
                $max = $data['score'];
                $dominant = $type;
            }
        }
        return $dominant;
    }



    private static function getKarmicLessonInterpretation($number)
    {
        $lessons = self::getKarmicLessonsData();
        if (isset($lessons[$number])) {
            return [
                'title' => $lessons[$number]['title'],
                'meaning' => $lessons[$number]['meaning']
            ];
        }
        return [
            'title' => 'Bài học đặc biệt',
            'meaning' => 'Chưa có thông tin chi tiết cho bài học này.'
        ];
    }

    /**
     * Data đầy đủ về bài học Karmic (số thiếu hụt) từ source code
     */
    private static function getKarmicLessonsData()
    {
        return [
            1 => [
                'number' => 1,
                'title' => 'Thiếu Số 1 – Bài Học về Sự Tự Tin & Chính Kiến',
                'meaning' => 'Việc thiếu số 1 trong tên cho thấy bạn mang theo một bài học sâu sắc về lòng tự tin và khả năng khẳng định bản thân. Bạn có thể cảm thấy khó khăn khi phải tự đưa ra quyết định, dễ hoài nghi giá trị của chính mình và ngại thể hiện ý kiến cá nhân. Điều này khiến bạn đôi khi đánh mất cơ hội, chỉ vì không dám bước lên và nói: "Tôi có thể." Bài học của bạn là học cách tin tưởng vào chính mình – dù chưa hoàn hảo. Hãy tập chủ động từ những việc nhỏ, dám chia sẻ quan điểm, và kiên nhẫn rèn luyện sự dũng cảm nội tâm. Khi bạn dám đứng vào vị trí người dẫn dắt cuộc đời mình, mọi cánh cửa sẽ mở ra theo cách mà trước đây bạn chưa từng nghĩ đến.'
            ],
            2 => [
                'number' => 2,
                'title' => 'Thiếu Số 2 – Bài Học về Sự Hợp Tác & Đồng Cảm',
                'meaning' => 'Việc thiếu số 2 trong tên cho thấy bạn đang mang theo một bài học quan trọng về khả năng hợp tác, sự nhạy cảm và tinh thần đồng đội. Trong quá khứ, bạn có thể đã sống hơi thiên về cá nhân, ít chú ý đến cảm xúc người khác hoặc thiếu kiên nhẫn trong các mối quan hệ. Chính vì vậy, kiếp này bạn cần học cách lắng nghe, làm việc nhóm và hành xử khéo léo hơn. Bài học của bạn là phát triển năng lượng của con số 2: biết dùng sự tinh tế, kiên nhẫn và lòng cảm thông để tạo nên sự hòa hợp trong mọi tương tác. Hãy học cách đặt lợi ích chung lên trước, đón nhận vai trò người hỗ trợ nhẹ nhàng, và tin rằng thành công có thể đến từ việc chúng ta đi cùng nhau. Khi biết kết nối bằng trái tim và sự tôn trọng, bạn sẽ tạo ra một sức mạnh bền vững không thể thiếu trong mỗi tập thể.'
            ],
            3 => [
                'number' => 3,
                'title' => 'Thiếu Số 3 – Bài Học về Khả Năng Biểu Đạt & Sáng Tạo',
                'meaning' => 'Việc thiếu số 3 trong tên cho thấy bạn đang học cách giải phóng tiếng nói nội tâm, khơi gợi sáng tạo và tìm thấy niềm vui trong cuộc sống. Bạn có thể thường cảm thấy khó diễn đạt cảm xúc, bị chính mình phán xét quá khắt khe hoặc không dám đứng lên để nói ra ý kiến. Điều này khiến bạn dễ bỏ lỡ cơ hội kết nối, chia sẻ niềm vui và truyền cảm hứng. Bài học của bạn là học cách thoát khỏi sự tự ti, bớt nghiêm trọng hóa mọi thứ, và dám tỏa sáng theo cách riêng mình. Hãy thử dành thời gian cho các hoạt động sáng tạo – kể chuyện, viết lách, trò chuyện thú vị hoặc đơn giản là cho phép mình cười đùa mà không cần lý do. Khi bạn biết nhẹ nhàng chia sẻ cảm xúc và đón nhận sự vui vẻ, cuộc sống sẽ trở nên đầy cảm hứng, và bạn sẽ trở thành người lan tỏa năng lượng tích cực đến mọi người xung quanh.'
            ],
            4 => [
                'number' => 4,
                'title' => 'Thiếu Số 4 – Bài Học về Kỷ Luật & Kiên Trì',
                'meaning' => 'Việc thiếu số 4 trong tên cho thấy bạn đang đối diện bài học quan trọng về kỷ luật, tổ chức và chịu trách nhiệm. Bạn có thể bắt đầu nhiều dự án với tâm huyết nhưng lại gặp khó khăn trong việc duy trì nỗ lực đến khi hoàn thành. Trong quá khứ, bạn có thể đã tránh né công việc đòi hỏi kiên trì hoặc không chịu xây dựng nền tảng vững chắc ngay từ đầu. Khi thiếu số 4, bạn dễ cảm thấy rối ren, thiếu cấu trúc, và dễ chuyển việc hoặc thay đổi lối sống mỗi khi cảm thấy chán nản hoặc thất vọng. Bài học của bạn là: Học cách lập kế hoạch nhỏ – từng bước để dự án không bị bỏ dở. Xây dựng thói quen có kỷ luật, từ việc sắp xếp góc làm việc đến quản lý thời gian. Biết nắm giữ cam kết và hoàn thiện mọi việc đã bắt đầu – dù không còn hào hứng như lúc khởi đầu.'
            ],
            5 => [
                'number' => 5,
                'title' => 'Thiếu Số 5 – Bài Học về Tự Do, Linh Hoạt & Dám Thay Đổi',
                'meaning' => 'Việc thiếu số 5 trong tên cho thấy bạn đang cần học cách chào đón sự thay đổi, mở rộng tầm nhìn và sống linh hoạt hơn. Có thể trong quá khứ bạn đã tránh né rủi ro, không thích phá vỡ thói quen, dẫn đến cuộc sống trở nên an toàn đến mức khô cứng. Vì vậy, bài học kiếp này là học cách thả lỏng, chấp nhận dòng chảy của cuộc sống – giống như một dòng sông mềm mại chạm trôi mọi trở ngại. Bài học chính bạn cần nắm là: Can đảng thử điều mới, dù chỉ từ hành động nhỏ: thử món ăn, thay lịch đi, gặp một người mới. Linh hoạt trước biến động và biết điều chỉnh kế hoạch khi hoàn cảnh thay đổi – đừng sợ xê dịch. Học cách sử dụng tự do một cách xây dựng, không để bản thân lạc hướng hay mất kiểm soát.'
            ],
            6 => [
                'number' => 6,
                'title' => 'Thiếu Số 6 – Bài Học về Trách Nhiệm, Cam Kết & Chăm Sóc',
                'meaning' => 'Việc tên bạn không có số 6 cho thấy linh hồn đang mang theo một bài học về trách nhiệm, tình yêu và cam kết trong các mối quan hệ, đặc biệt là trong gia đình và môi trường thân thiết. Bạn có thể từng tránh né những trách vụ gắn bó lâu dài, từ việc xây tổ ấm đến việc duy trì mối quan hệ sâu sắc, nên đôi khi cảm thấy không thoải mái với vai trò chăm sóc hoặc chịu trách nhiệm. Bài học cần rèn luyện là: Tiếp nhận trách nhiệm – dù là chăm sóc gia đình nhỏ, hoàn thành cam kết hay hỗ trợ người thân – một cách tự nguyện, không miễn cưỡng. Học cách yêu thương không điều kiện, biết lắng nghe và quan tâm mà không mong đợi, đồng thời thiết lập ranh giới để không bị kiệt sức. Tạo dựng môi trường hòa hợp, từ nhà cửa đến các mối quan hệ – học cách chăm sóc, nuôi dưỡng cảm xúc và sự gắn bó trong dài hạn.'
            ],
            7 => [
                'number' => 7,
                'title' => 'Thiếu Số 7 – Bài Học về Trí Tuệ Nội Tâm và Trực Giác',
                'meaning' => 'Việc thiếu số 7 trong tên cho thấy bạn đang học cách tin vào trực giác, kết nối sâu với bản thân và nuôi dưỡng trí tuệ nội tâm. Bạn có thể cảm thấy khó chịu với sự tĩnh lặng, ngại nhìn lại chính mình hoặc thường né tránh những suy tư sâu sắc. Người có bài học này dễ sống hướng ngoại quá mức, quá lý trí, hoặc luôn bận rộn để tránh đối diện với thế giới bên trong. Bài học của bạn là: Tập dành thời gian cho khoảng lặng cá nhân, dù chỉ vài phút mỗi ngày để lắng nghe cảm xúc thật của mình. Học cách tin vào linh cảm, không cần lúc nào cũng lý giải bằng logic. Khám phá các lĩnh vực như thiền định, triết học, tâm linh để nuôi dưỡng chiều sâu tâm hồn.'
            ],
            8 => [
                'number' => 8,
                'title' => 'Thiếu Số 8 – Bài Học về Quyền Lực, Tham Vọng và Quản Lý Tài Chính',
                'meaning' => 'Việc thiếu số 8 trong tên cho thấy bạn đang học cách ứng xử khéo léo với quyền lực, tài chính và tham vọng cá nhân. Trong quá khứ, bạn có thể đã tránh né các tình huống đòi hỏi lãnh đạo, lo ngại việc nắm quyền, hoặc chưa tìm được cách quản lý tiền bạc hiệu quả – dẫn đến những thăng trầm liên tục trong tài chính hoặc cảm giác bất lực trước sự thay đổi. Bài học này mời bạn: Phát triển thói quen kỷ luật và tổ chức tài chính như lập ngân sách, tiết kiệm và đầu tư có chiến lược. Học cách chấp nhận trách nhiệm và nắm vai trò lãnh đạo thay vì né tránh quyền lực. Kiểm soát xu hướng cứng nhắc hoặc cư xử độc quyền, để sức mạnh cá nhân đi cùng với tinh thần phục vụ và chính trực.'
            ],
            9 => [
                'number' => 9,
                'title' => 'Thiếu Số 9 – Bài Học về Lòng Đồng Cảm, Tha Thứ & Buông Bỏ',
                'meaning' => 'Thiếu số 9 trong tên cho thấy linh hồn bạn đang mang theo một bài học sâu sắc về sự cảm thông, tha thứ và khả năng buông bỏ. Có thể bạn thường thấy mình khó tiếp cận được cảm xúc của người khác, giữ mãi những hận thù cũ hoặc không dễ chấp nhận sự thay đổi và kết thúc của một giai đoạn trong cuộc sống. Để trưởng thành, bạn được mời gọi: Mở rộng lòng mình để hiểu và đồng cảm với hoàn cảnh của người khác, ngay cả khi họ khác biệt với bạn. Học cách tha thứ và rũ bỏ quá khứ – cho cả bản thân và người khác – để tạo cảm giác tự do nội tâm. Chấp nhận sự kết thúc như một phần tất yếu trong vòng quay của cuộc sống, để đón nhận điều mới mẻ.'
            ],
            'all_numbers' => [
                'number' => 0,
                'title' => 'Không Thiếu Số – Linh Hồn Toàn Diện và Cân Bằng',
                'meaning' => 'Khi bạn không thiếu bất kỳ con số nào từ 1 đến 9 trong tên, điều đó cho thấy linh hồn bạn đã trải nghiệm khá đầy đủ các khía cạnh của nhân cách trong những kiếp sống trước. Bạn có sự cân bằng tự nhiên giữa lý trí và cảm xúc, hành động và trực giác, tham vọng và vị tha. Người có đủ 9 con số thường sở hữu nội lực đa chiều, tư duy linh hoạt và khả năng thích nghi vượt trội. Tuy không mang theo bài học "thiếu hụt" cụ thể nào, bạn vẫn cần duy trì sự phát triển bằng cách: Khám phá và đào sâu những thế mạnh sẵn có, thay vì chỉ dừng lại ở mức "đủ dùng". Học cách dẫn dắt người khác bằng trải nghiệm đa dạng và sự đồng cảm bẩm sinh. Tránh rơi vào trạng thái tự mãn hoặc chủ quan vì ít gặp trở ngại nội tại rõ rệt.'
            ]
        ];
    }

    private static function getKarmicLessonsInterpretation($missing, $passions)
    {
        $result = 'Số thiếu hụt: ' . implode(', ', $missing) . '. ';
        $result .= 'Số tiềm năng: ' . implode(', ', $passions) . '.';
        return $result;
    }

    private static function getKarmicDebtInterpretation($number)
    {
        $debts = [
            13 => 'Nghiệp quả từ sự lười biếng và thiếu trách nhiệm.',
            14 => 'Nghiệp quả từ việc lạm dụng tự do.',
            16 => 'Nghiệp quả từ sự kiêu ngạo và phá hoại tình yêu.',
            19 => 'Nghiệp quả từ việc lạm dụng quyền lực.'
        ];
        return $debts[$number] ?? 'Nghiệp quả đặc biệt.';
    }

    private static function getKarmicDebtSections($debts) { return []; }

    private static function getMissingNumbersInterpretation($missing, $passions)
    {
        $result = 'Số thiếu hụt trong tên: ' . implode(', ', $missing) . '. ';
        $result .= 'Số tiềm ẩn: ' . implode(', ', $passions) . '.';
        return $result;
    }

    private static function getMissingNumbersSections($missing, $passions) { return []; }

    /**
     * Lấy diễn giải theo tần suất xuất hiện
     */
    private static function getFrequencyInterpretation($number, $frequency)
    {
        $key = "{$number}_{$frequency}";
        $interpretations = self::getFrequencyInterpretations();

        if (isset($interpretations[$key])) {
            return [
                'summary' => $interpretations[$key]['summary'],
                'meaning' => $interpretations[$key]['meaning']
            ];
        }

        return [
            'summary' => "Số {$number} xuất hiện {$frequency} lần",
            'meaning' => "Chưa có diễn giải chi tiết cho tần suất này."
        ];
    }

    /**
     * Data diễn giải theo tần suất - Đầy đủ từ source code
     */
    private static function getFrequencyInterpretations()
    {
        return [
            // ==================== SỐ 1 ====================
            '1_0' => [
                'summary' => 'Số lần xuất hiện của số 1: 0 lần',
                'meaning' => 'Việc thiếu vắng số 1 cho thấy cá nhân có xu hướng thiếu tự tin, e dè trong việc khẳng định bản thân và dễ bị ảnh hưởng bởi ý kiến người khác. Họ thường ngại bày tỏ chính kiến, gặp khó khăn khi cần thể hiện quan điểm cá nhân hoặc khi được giao vai trò lãnh đạo. Ngoài ra, họ có thể sống nội tâm, ít dám khởi đầu điều mới hoặc không tin tưởng vào năng lực của chính mình. Đây là nhóm người cần học bài học về sự can đảm, chính kiến và rèn luyện bản lĩnh cá nhân để trưởng thành trong cuộc sống.'
            ],
            '1_1' => [
                'summary' => 'Số lần xuất hiện của số 1: 1 lần',
                'meaning' => 'Khi số 1 xuất hiện duy nhất một lần trong Biểu đồ ngày sinh, điều này cho thấy cá nhân có tiềm năng về sự tự tin và khả năng lãnh đạo, nhưng những phẩm chất này chưa được phát triển đầy đủ. Bạn có thể cảm thấy ngại ngùng trong việc thể hiện bản thân và thường do dự khi cần đưa ra quyết định quan trọng. Mặc dù có khả năng giao tiếp, bạn có xu hướng giữ kín suy nghĩ và cảm xúc, dẫn đến việc người khác khó hiểu bạn. Để phát triển, bạn cần rèn luyện sự tự tin, học cách bày tỏ quan điểm một cách rõ ràng và dũng cảm hơn trong việc khởi xướng các dự án hoặc ý tưởng mới.'
            ],
            '1_2' => [
                'summary' => 'Số lần xuất hiện của số 1: 2 lần',
                'meaning' => 'Khi số 1 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy cá nhân có khả năng giao tiếp tốt và dễ dàng kết bạn. Bạn có xu hướng thích nghi với môi trường xung quanh, đôi khi trở nên nói nhiều và sôi nổi, nhưng cũng có lúc im lặng và trầm lắng. Bạn thường thể hiện tốt trong lĩnh vực của mình, có sự đồng cảm với người khác và duy trì tình hình tài chính ổn định. Bạn là những người diễn thuyết hiệu quả và có thể bày tỏ quan điểm một cách cởi mở.'
            ],
            '1_3' => [
                'summary' => 'Số lần xuất hiện của số 1: 3 lần',
                'meaning' => 'Khi số 1 xuất hiện ba lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có khả năng giao tiếp mạnh mẽ và thường là trung tâm của sự chú ý trong các cuộc trò chuyện. Bạn có thể nói chuyện liên tục trong nhiều giờ về bất kỳ chủ đề nào, và sự nhiệt tình của bạn thường truyền cảm hứng cho người khác. Tuy nhiên, sự nói nhiều này đôi khi có thể dẫn đến việc bạn vô tình làm tổn thương người khác hoặc làm hỏng các mối quan hệ do thiếu sự lắng nghe. Bạn có xu hướng thể hiện kiến thức của mình một cách tự hào, điều này có thể bị người khác coi là khoe khoang. Để phát triển tốt hơn, bạn nên học cách cân bằng giữa việc nói và lắng nghe, cũng như thể hiện sự khiêm tốn trong giao tiếp.'
            ],
            '1_4' => [
                'summary' => 'Số lần xuất hiện của số 1: 4 lần',
                'meaning' => 'Khi số 1 xuất hiện 4 lần trong Biểu đồ ngày sinh, điều này cho thấy bạn là người tốt bụng và đam mê công việc. Tuy nhiên, bạn có thể gặp khó khăn trong giao tiếp, dẫn đến mâu thuẫn trong các mối quan hệ. Lòng tốt của bạn khiến bạn sẵn lòng giúp đỡ người khác, nhưng bạn có thể gặp khó khăn trong việc ổn định ở một nơi. Nếu bạn học cách sử dụng lời nói một cách khôn ngoan, bạn có thể trở thành một diễn giả truyền cảm hứng hoặc nhân vật công chúng.'
            ],
            '1_5' => [
                'summary' => 'Số lần xuất hiện của số 1: 5 lần',
                'meaning' => 'Khi số 1 xuất hiện 5 lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể gặp những thách thức về mặt tinh thần và cảm xúc. Bạn có xu hướng dễ bị dao động trong suy nghĩ, dẫn đến cảm giác bất an và khó khăn trong việc duy trì sự ổn định. Mặc dù bạn có nhiều cơ hội để đạt được thành công trong cuộc sống, nhưng điều này đòi hỏi bạn phải nỗ lực rất nhiều và kiên trì vượt qua những trở ngại nội tâm. Sau khi đạt được thành công, bạn có thể cảm thấy tự hào về bản thân, nhưng cũng cần cẩn trọng để không trở nên kiêu ngạo. Bạn có thể cảm thấy lo lắng hoặc run rẩy khi phải nói trước đám đông, nhưng với sự luyện tập và quyết tâm, bạn có thể phát triển sự tự tin và trở thành một người giao tiếp hiệu quả.'
            ],
            '1_6' => [
                'summary' => 'Số lần xuất hiện của số 1: 6 lần',
                'meaning' => 'Khi số 1 xuất hiện 6 lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng mạnh mẽ về sự độc lập và khả năng lãnh đạo. Tuy nhiên, sự lặp lại quá nhiều của số 1 có thể dẫn đến tính cách cứng đầu, thiếu linh hoạt và khó tiếp nhận ý kiến từ người khác. Bạn có thể trở nên quá tự tin, dẫn đến việc không lắng nghe người khác và dễ gây ra xung đột trong các mối quan hệ. Để phát triển tốt hơn, bạn nên học cách lắng nghe và tôn trọng quan điểm của người khác, đồng thời rèn luyện sự linh hoạt trong tư duy và hành động. Việc cân bằng giữa sự tự tin và khiêm tốn sẽ giúp bạn xây dựng các mối quan hệ hài hòa và đạt được thành công bền vững.'
            ],

            // ==================== SỐ 2 ====================
            '2_0' => [
                'summary' => 'Số lần xuất hiện của số 2: 0 lần',
                'meaning' => 'Khi số 2 không xuất hiện trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể gặp khó khăn trong việc thể hiện cảm xúc và thiếu sự nhạy bén trong các mối quan hệ. Bạn có thể cảm thấy khó khăn trong việc lắng nghe trực giác, dẫn đến quyết định thiếu cân nhắc. Ngoài ra, bạn có thể thiếu kiên nhẫn, khó duy trì lịch trình và gặp khó khăn trong việc giữ gìn mối quan hệ lâu dài. Điều này có thể ảnh hưởng đến sức khỏe tinh thần và gây ra cảm giác cô đơn.'
            ],
            '2_1' => [
                'summary' => 'Số lần xuất hiện của số 2: 1 lần',
                'meaning' => 'Khi số 2 xuất hiện duy nhất một lần trong Biểu đồ ngày sinh, điều này cho thấy bạn là người nhạy cảm, tình cảm và có trực giác tốt. Bạn có xu hướng quan tâm sâu sắc đến gia đình, luôn nỗ lực để duy trì sự hòa hợp và hỗ trợ trong môi trường gia đình. Tuy nhiên, bạn có thể dễ bị tổn thương bởi những lời nói hoặc hành động của người khác, và có thể phản ứng mạnh mẽ với những điều nhỏ nhặt. Mặc dù bạn có trực giác tốt, nhưng đôi khi bạn không tin tưởng vào cảm nhận của mình, dẫn đến việc bỏ lỡ cơ hội hoặc không giải quyết được vấn đề một cách hiệu quả. Để phát triển, bạn nên học cách tin tưởng vào trực giác, quản lý cảm xúc và xây dựng sự tự tin trong các mối quan hệ.'
            ],
            '2_2' => [
                'summary' => 'Số lần xuất hiện của số 2: 2 lần',
                'meaning' => 'Khi số 2 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu trực giác mạnh mẽ và khả năng thấu hiểu sâu sắc cảm xúc của người khác. Bạn có thể giữ bình tĩnh trong những tình huống căng thẳng và thường là người giải quyết xung đột một cách khéo léo. Tuy nhiên, bạn cũng có xu hướng giữ kín suy nghĩ và cảm xúc, khiến người khác khó hiểu bạn. Để phát triển, bạn nên học cách mở lòng hơn và chia sẻ cảm xúc một cách chân thành, điều này sẽ giúp bạn xây dựng các mối quan hệ sâu sắc và bền vững hơn.'
            ],
            '2_3' => [
                'summary' => 'Số lần xuất hiện của số 2: 3 lần',
                'meaning' => 'Khi số 2 xuất hiện ba lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có độ nhạy cảm và trực giác rất cao. Bạn dễ bị ảnh hưởng bởi cảm xúc của người khác và có khả năng thấu hiểu sâu sắc tâm trạng xung quanh. Tuy nhiên, sự nhạy cảm này có thể khiến bạn dễ bị tổn thương và có xu hướng rút lui vào thế giới nội tâm. Bạn có thể cảm thấy khó khăn trong việc thiết lập ranh giới cảm xúc và cần học cách bảo vệ bản thân khỏi những ảnh hưởng tiêu cực từ môi trường xung quanh.'
            ],
            '2_4' => [
                'summary' => 'Số lần xuất hiện của số 2: 4 lần',
                'meaning' => 'Khi số 2 xuất hiện bốn lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu trực giác mạnh mẽ và khả năng thấu hiểu sâu sắc cảm xúc của người khác. Bạn có thể giữ bình tĩnh trong những tình huống căng thẳng và thường là người giải quyết xung đột một cách khéo léo. Tuy nhiên, bạn cũng có xu hướng giữ kín suy nghĩ và cảm xúc, khiến người khác khó hiểu bạn.'
            ],
            '2_5' => [
                'summary' => 'Số lần xuất hiện của số 2: 5 lần',
                'meaning' => 'Khi số 2 xuất hiện năm lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu trực giác mạnh mẽ và khả năng thấu hiểu sâu sắc cảm xúc của người khác. Bạn có thể giữ bình tĩnh trong những tình huống căng thẳng và thường là người giải quyết xung đột một cách khéo léo.'
            ],
            '2_6' => [
                'summary' => 'Số lần xuất hiện của số 2: 6 lần',
                'meaning' => 'Khi số 2 xuất hiện 6 lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu trực giác mạnh mẽ và khả năng thấu hiểu sâu sắc cảm xúc của người khác. Bạn có thể giữ bình tĩnh trong những tình huống căng thẳng và thường là người giải quyết xung đột một cách khéo léo.'
            ],

            // ==================== SỐ 3 ====================
            '3_0' => [
                'summary' => 'Số lần xuất hiện của số 3: 0 lần',
                'meaning' => 'Khi số 3 không xuất hiện trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể gặp khó khăn trong việc biểu đạt suy nghĩ và cảm xúc, dẫn đến thiếu tự tin và khả năng giao tiếp hạn chế. Bạn có thể cảm thấy thiếu định hướng, khó khăn trong việc đưa ra quyết định và dễ bị phân tâm.'
            ],
            '3_1' => [
                'summary' => 'Số lần xuất hiện của số 3: 1 lần',
                'meaning' => 'Khi số 3 xuất hiện một lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng sáng tạo và khả năng giao tiếp, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ. Bạn có thể cảm thấy khó khăn trong việc biểu đạt suy nghĩ và cảm xúc, dẫn đến thiếu tự tin trong giao tiếp.'
            ],
            '3_2' => [
                'summary' => 'Số lần xuất hiện của số 3: 2 lần',
                'meaning' => 'Khi số 3 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu trí tưởng tượng phong phú và khả năng giao tiếp tốt. Bạn có xu hướng sáng tạo và linh hoạt trong cách suy nghĩ, giúp bạn dễ dàng thích nghi với các tình huống khác nhau.'
            ],
            '3_3' => [
                'summary' => 'Số lần xuất hiện của số 3: 3 lần',
                'meaning' => 'Khi số 3 xuất hiện ba lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu trí tưởng tượng phong phú và khả năng giao tiếp tốt. Bạn có xu hướng sáng tạo và linh hoạt trong cách suy nghĩ, giúp bạn dễ dàng thích nghi với các tình huống khác nhau.'
            ],
            '3_4' => [
                'summary' => 'Số lần xuất hiện của số 3: 4 lần',
                'meaning' => 'Khi số 3 xuất hiện 4 lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu trí tưởng tượng phong phú và khả năng giao tiếp tốt. Bạn có xu hướng sáng tạo và linh hoạt trong cách suy nghĩ, giúp bạn dễ dàng thích nghi với các tình huống khác nhau.'
            ],

            // ==================== SỐ 4 ====================
            '4_0' => [
                'summary' => 'Số lần xuất hiện của số 4: 0 lần',
                'meaning' => 'Khi số 4 không xuất hiện trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể thiếu tính tổ chức, kỷ luật và sự kiên định trong cuộc sống. Bạn có thể gặp khó khăn trong việc lập kế hoạch, duy trì thói quen và hoàn thành công việc đúng hạn.'
            ],
            '4_1' => [
                'summary' => 'Số lần xuất hiện của số 4: 1 lần',
                'meaning' => 'Khi số 4 xuất hiện một lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng về tính tổ chức, kỷ luật và sự kiên định, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ. Bạn có thể cảm thấy khó khăn trong việc lập kế hoạch, duy trì thói quen và hoàn thành công việc đúng hạn.'
            ],
            '4_2' => [
                'summary' => 'Số lần xuất hiện của số 4: 2 lần',
                'meaning' => 'Khi số 4 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu tính tổ chức và kỷ luật cao, cùng với sự kiên định trong cuộc sống. Bạn có khả năng lập kế hoạch, duy trì thói quen và hoàn thành công việc đúng hạn.'
            ],
            '4_3' => [
                'summary' => 'Số lần xuất hiện của số 4: 3 lần',
                'meaning' => 'Khi số 4 xuất hiện ba lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu tính tổ chức và kỷ luật cao, cùng với sự kiên định trong cuộc sống. Bạn có khả năng lập kế hoạch, duy trì thói quen và hoàn thành công việc đúng hạn.'
            ],
            '4_4' => [
                'summary' => 'Số lần xuất hiện của số 4: 4 lần',
                'meaning' => 'Khi số 4 xuất hiện 4 lần, bạn là người cực kỳ nguyên tắc, logic và có năng lực tuyệt vời trong việc lập kế hoạch, duy trì trật tự, kiểm soát và kiên trì đến cùng. Bạn thường có cái nhìn thực tế sắc bén, không bị cuốn theo cảm xúc hay mộng mơ viễn vông.'
            ],

            // ==================== SỐ 5 ====================
            '5_0' => [
                'summary' => 'Số lần xuất hiện của số 5: 0 lần',
                'meaning' => 'Khi số 5 không xuất hiện trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể thiếu sự linh hoạt, khả năng giao tiếp, và tinh thần phiêu lưu. Bạn có thể cảm thấy khó khăn trong việc thích nghi với thay đổi, thiếu sự tò mò, và gặp khó khăn trong việc biểu đạt suy nghĩ.'
            ],
            '5_1' => [
                'summary' => 'Số lần xuất hiện của số 5: 1 lần',
                'meaning' => 'Khi số 5 xuất hiện một lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng về sự linh hoạt, khả năng giao tiếp, và tinh thần phiêu lưu, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ.'
            ],
            '5_2' => [
                'summary' => 'Số lần xuất hiện của số 5: 2 lần',
                'meaning' => 'Khi số 5 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng về sự linh hoạt, khả năng giao tiếp, và tinh thần phiêu lưu, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ.'
            ],
            '5_3' => [
                'summary' => 'Số lần xuất hiện của số 5: 3 lần',
                'meaning' => 'Khi số 5 xuất hiện ba lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng mạnh mẽ về sự tự do và phiêu lưu. Bạn có khả năng thích nghi nhanh chóng với những thay đổi và thường xuyên tìm kiếm những trải nghiệm mới.'
            ],
            '5_4' => [
                'summary' => 'Số lần xuất hiện của số 5: 4 lần',
                'meaning' => 'Khi số 5 xuất hiện 4 lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng mạnh mẽ về sự tự do và phiêu lưu. Bạn có khả năng thích nghi nhanh chóng với những thay đổi và thường xuyên tìm kiếm những trải nghiệm mới.'
            ],

            // ==================== SỐ 6 ====================
            '6_0' => [
                'summary' => 'Số lần xuất hiện của số 6: 0 lần',
                'meaning' => 'Khi số 6 không xuất hiện trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể thiếu sự quan tâm đến gia đình, khả năng nuôi dưỡng, và trách nhiệm trong các mối quan hệ. Bạn có thể cảm thấy khó khăn trong việc thể hiện tình cảm, thiếu sự đồng cảm, và gặp khó khăn trong việc duy trì mối quan hệ lâu dài.'
            ],
            '6_1' => [
                'summary' => 'Số lần xuất hiện của số 6: 1 lần',
                'meaning' => 'Khi số 6 xuất hiện một lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng về tình yêu, sự hài hòa, trách nhiệm, và sự nuôi dưỡng, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ.'
            ],
            '6_2' => [
                'summary' => 'Số lần xuất hiện của số 6: 2 lần',
                'meaning' => 'Khi số 6 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng về tình yêu, sự hài hòa, trách nhiệm, và sự nuôi dưỡng, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ.'
            ],
            '6_3' => [
                'summary' => 'Số lần xuất hiện của số 6: 3 lần',
                'meaning' => 'Khi số 6 xuất hiện ba lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có năng lượng mạnh mẽ về tình yêu và sự nuôi dưỡng. Bạn có khả năng xây dựng mối quan hệ bền vững, tạo ra môi trường ấm áp, và đóng vai trò là người chăm sóc trong gia đình và cộng đồng.'
            ],
            '6_4' => [
                'summary' => 'Số lần xuất hiện của số 6: 4 lần',
                'meaning' => 'Khi số 6 xuất hiện 4 lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng mạnh mẽ về tình yêu và sự nuôi dưỡng. Bạn có khả năng xây dựng mối quan hệ bền vững, tạo ra môi trường ấm áp, và đóng vai trò là người chăm sóc trong gia đình và cộng đồng.'
            ],

            // ==================== SỐ 7 ====================
            '7_0' => [
                'summary' => 'Số lần xuất hiện của số 7: 0 lần',
                'meaning' => 'Khi số 7 không xuất hiện trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể thiếu khả năng tư duy sâu sắc, trực giác, và kết nối với thế giới nội tâm. Bạn có thể cảm thấy khó khăn trong việc tìm kiếm ý nghĩa sâu xa của cuộc sống, thiếu sự chiêm nghiệm, và gặp khó khăn trong việc tin tưởng vào trực giác của mình.'
            ],
            '7_1' => [
                'summary' => 'Số lần xuất hiện của số 7: 1 lần',
                'meaning' => 'Khi số 7 xuất hiện một lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng về trí tuệ, trực giác, và sự chiêm nghiệm, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ.'
            ],
            '7_2' => [
                'summary' => 'Số lần xuất hiện của số 7: 2 lần',
                'meaning' => 'Khi số 7 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng mạnh mẽ về trí tuệ và trực giác. Bạn có khả năng phân tích sâu sắc, tìm kiếm kiến thức và kết nối với thế giới nội tâm.'
            ],
            '7_3' => [
                'summary' => 'Số lần xuất hiện của số 7: 3 lần',
                'meaning' => 'Khi số 7 xuất hiện ba lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng mạnh mẽ về trí tuệ và trực giác. Bạn có khả năng phân tích sâu sắc, tìm kiếm kiến thức và kết nối với thế giới nội tâm.'
            ],
            '7_4' => [
                'summary' => 'Số lần xuất hiện của số 7: 4 lần',
                'meaning' => 'Khi số 7 xuất hiện bốn lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng mạnh mẽ về trí tuệ và trực giác. Bạn có khả năng phân tích sâu sắc, tìm kiếm kiến thức và kết nối với thế giới nội tâm.'
            ],

            // ==================== SỐ 8 ====================
            '8_0' => [
                'summary' => 'Số lần xuất hiện của số 8: 0 lần',
                'meaning' => 'Khi số 8 không xuất hiện trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể thiếu khả năng quản lý tài chính, sự kiên trì, và khả năng đạt được thành công vật chất. Bạn có thể cảm thấy khó khăn trong việc đưa ra quyết định tài chính, thiếu động lực, và gặp khó khăn trong việc duy trì sự ổn định trong cuộc sống cá nhân và nghề nghiệp.'
            ],
            '8_1' => [
                'summary' => 'Số lần xuất hiện của số 8: 1 lần',
                'meaning' => 'Khi số 8 xuất hiện một lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng về sức mạnh và tham vọng, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ. Bạn có thể cảm thấy khó khăn trong việc đưa ra quyết định tài chính, thiếu động lực, và gặp khó khăn trong việc duy trì sự ổn định trong cuộc sống cá nhân và nghề nghiệp.'
            ],
            '8_2' => [
                'summary' => 'Số lần xuất hiện của số 8: 2 lần',
                'meaning' => 'Khi số 8 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có năng lượng mạnh mẽ về sức mạnh và tham vọng. Bạn có khả năng quản lý tài chính, đưa ra quyết định nhanh chóng, và đạt được thành công trong sự nghiệp.'
            ],
            '8_3' => [
                'summary' => 'Số lần xuất hiện của số 8: 3 lần',
                'meaning' => 'Khi số 8 xuất hiện 3 lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng rất mạnh mẽ về tham vọng, khả năng điều hành và tư duy thực tế. Bạn thường là người có khát khao lớn trong việc đạt được quyền lực, tiền bạc hoặc địa vị xã hội.'
            ],
            '8_4' => [
                'summary' => 'Số lần xuất hiện của số 8: 4 lần',
                'meaning' => 'Khi số 8 xuất hiện 4 lần, bạn là người mang năng lượng vật chất cực kỳ mạnh mẽ, điều này có thể tạo nên một cá nhân vô cùng quyết đoán, kiên cường và khao khát thành tựu vượt trội. Bạn rất có khả năng thành công trong lĩnh vực tài chính, kinh doanh hoặc lãnh đạo tổ chức.'
            ],

            // ==================== SỐ 9 ====================
            '9_0' => [
                'summary' => 'Số lần xuất hiện của số 9: 0 lần',
                'meaning' => 'Khi số 9 không xuất hiện trong Biểu đồ ngày sinh, điều này cho thấy bạn có thể thiếu lòng nhân ái, sự tha thứ, và khả năng kết nối với cộng đồng. Bạn có thể cảm thấy khó khăn trong việc thấu hiểu cảm xúc của người khác, thiếu động lực để giúp đỡ cộng đồng, và gặp khó khăn trong việc buông bỏ quá khứ.'
            ],
            '9_1' => [
                'summary' => 'Số lần xuất hiện của số 9: 1 lần',
                'meaning' => 'Khi số 9 xuất hiện một lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có tiềm năng về lòng nhân ái, sự tha thứ, và khả năng kết nối với cộng đồng, nhưng những phẩm chất này có thể chưa được phát huy đầy đủ.'
            ],
            '9_2' => [
                'summary' => 'Số lần xuất hiện của số 9: 2 lần',
                'meaning' => 'Khi số 9 xuất hiện hai lần trong Biểu đồ ngày sinh, điều này cho thấy bạn có năng lượng mạnh mẽ về lòng nhân ái và tinh thần phục vụ cộng đồng. Bạn có khả năng thấu hiểu cảm xúc của người khác, sẵn lòng giúp đỡ cộng đồng, và dễ dàng buông bỏ quá khứ.'
            ],
            '9_3' => [
                'summary' => 'Số lần xuất hiện của số 9: 3 lần',
                'meaning' => 'Khi số 9 xuất hiện ba lần trong Biểu đồ ngày sinh, điều này cho thấy bạn sở hữu năng lượng mạnh mẽ về lòng nhân ái và tinh thần phục vụ cộng đồng. Bạn có khả năng thấu hiểu cảm xúc của người khác, sẵn lòng giúp đỡ cộng đồng, và dễ dàng buông bỏ quá khứ.'
            ],
            '9_4' => [
                'summary' => 'Số lần xuất hiện của số 9: 4 lần',
                'meaning' => 'Khi số 9 xuất hiện tới 4 lần, bạn sở hữu năng lượng tâm linh và tinh thần phục vụ rất lớn, nhưng cũng mang theo sự quá tải về cảm xúc và lý tưởng hóa thực tế. Bạn thường là người sống giàu lòng trắc ẩn, luôn muốn giúp đỡ người khác và sẵn sàng hy sinh quyền lợi cá nhân cho điều lớn lao hơn.'
            ],
            '9_5' => [
                'summary' => 'Số lần xuất hiện của số 9: 5 lần',
                'meaning' => 'Khi số 9 xuất hiện đến 5 lần trong Biểu đồ ngày sinh điều này phản ánh một tần suất cực hiếm và năng lượng tinh thần cực mạnh. Bạn là người sở hữu sứ mệnh tâm linh rõ ràng, có khả năng cảm nhận sâu sắc, thấu hiểu nhân sinh, và sẵn lòng hiến dâng vì lợi ích chung.'
            ]
        ];
    }

    /**
     * Tổng hợp tất cả thông tin thần số học
     */
    public static function getCompleteNumerologyProfile($birthDate, $fullName)
    {
        return [
            'basic_numbers' => [
                'life_path' => self::calculateLifePath($birthDate),
                'birth_day' => self::calculateBirthDayNumber($birthDate),
                'expression' => self::calculateExpressionNumber($fullName),
                'soul_urge' => self::calculateSoulUrge($fullName),
                'personality' => self::calculatePersonalityNumber($fullName),
                'attitude' => self::calculateAttitudeNumber($birthDate),
                'maturity' => self::calculateMaturityNumber($birthDate, $fullName)
            ],
            'cycles_and_pinnacles' => [
                'personal_year' => self::calculatePersonalYear($birthDate),
                'nine_year_cycle' => self::calculateNineYearCycle($birthDate),
                'life_pinnacles' => self::calculateLifePinnacles($birthDate)
            ],
            'charts_and_patterns' => [
                'birth_chart' => self::calculateBirthChart($birthDate),
                'missing_numbers_from_name' => self::calculateMissingNumbersFromName($fullName),
                'arrows' => self::calculateArrows(self::calculateBirthChart($birthDate))
            ],
            'karmic_influences' => [
                'karmic_lessons' => self::calculateKarmicLessons($fullName),
                'karmic_debt' => self::calculateKarmicDebt($birthDate, $fullName)
            ],
            'abilities' => [
                'innate_abilities' => self::calculateInnateAbilitiesWithInterpretations($fullName)
            ],
            'summary' => self::generateProfileSummary($birthDate, $fullName)
        ];
    }

    private static function generateProfileSummary($birthDate, $fullName)
    {
        $lifePath = self::calculateLifePath($birthDate);
        $expression = self::calculateExpressionNumber($fullName);

        return [
            'life_path_number' => $lifePath['number'],
            'expression_number' => $expression['number'],
            'key_traits' => self::getKeyTraits($lifePath['number'], $expression['number']),
            'main_challenge' => self::getMainChallenge($lifePath['number']),
            'life_purpose' => self::getLifePurpose($lifePath['number'])
        ];
    }

    private static function getKeyTraits($lifePath, $expression)
    {
        // Logic để kết hợp đặc điểm từ life path và expression
        return "Đặc điểm chính dựa trên số chủ đạo {$lifePath} và số tên {$expression}";
    }

    private static function getMainChallenge($lifePath)
    {
        return "Thách thức chính cho số chủ đạo {$lifePath}";
    }

    private static function getLifePurpose($lifePath)
    {
        return "Mục đích sống cho số chủ đạo {$lifePath}";
    }

    /**
     * Get soul urge interpretations data from source code
     */
    public static function getSoulUrgeInterpretationsData()
    {
        return [
            1 => [
                'title' => 'Số Linh Hồn 1',
                'fullText' => 'Bạn sinh ra với một tiếng gọi mạnh mẽ từ bên trong – khát khao độc lập, tự chủ và được dẫn dắt theo cách riêng của mình. Linh hồn bạn luôn tìm kiếm sự tự do trong hành động và suy nghĩ. Bạn không thích bị ràng buộc hay bị kiểm soát – thay vào đó, bạn muốn trở thành người khởi đầu, mở lối, và tự chịu trách nhiệm với chính cuộc đời mình.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Tinh thần tiên phong, sáng tạo và đổi mới.',
                    'Khả năng lãnh đạo tự nhiên và tạo ảnh hưởng.',
                    'Ý chí mạnh mẽ, không dễ lùi bước.',
                    'Tư duy độc lập, thích thử thách.',
                ],
                'challenges' => [
                    'Dễ trở nên bướng bỉnh, độc đoán nếu không kiểm soát được cái tôi.',
                    'Có xu hướng thiếu kiên nhẫn, muốn mọi thứ theo cách của mình.',
                    'Đôi lúc khó hợp tác hoặc làm việc nhóm, do quá chú trọng vào quyền tự quyết.',
                ],
                'advice' => [
                    'Bạn sinh ra không phải để đi theo con đường cũ, mà để tạo nên lối đi mới. Khi bạn dám tin vào khả năng dẫn dắt của mình – bằng cả sự tự tin và lòng khiêm tốn – bạn sẽ trở thành nguồn cảm hứng rực rỡ cho chính mình và cả những người xung quanh.',
                ],
                'careerFit' => [
                    'Lãnh đạo doanh nghiệp, CEO.',
                    'Khởi nghiệp, sáng lập startup.',
                    'Tư vấn chiến lược, cố vấn.',
                    'Nghệ thuật độc lập, sáng tạo nội dung.',
                    'Bất kỳ lĩnh vực nào cho phép thể hiện tính độc lập.',
                ],
                'loveGuidance' => [
                    'Bạn cần một người bạn đời tôn trọng không gian cá nhân và tham vọng của bạn. Khi yêu, bạn trung thành và mạnh mẽ, nhưng cũng cần cảm thấy tự do để phát triển theo cách riêng. Một mối quan hệ lý tưởng là khi cả hai cùng hỗ trợ nhau trưởng thành, không ai áp đặt ai.',
                ]
            ],
            2 => [
                'title' => 'Số Linh Hồn 2',
                'fullText' => 'Bạn có Số Linh Hồn là 2, sâu thẳm trong bạn là khát khao về sự hòa hợp, kết nối và thấu hiểu. Bạn là người nhạy cảm, tinh tế và luôn mong muốn xây dựng những mối quan hệ bền vững, nơi mọi người cảm thấy được lắng nghe và trân trọng. Bạn không chỉ tìm kiếm sự yên bình trong môi trường xung quanh mà còn là người chủ động tạo ra nó.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Thấu cảm sâu sắc: Bạn dễ dàng cảm nhận được cảm xúc của người khác và sẵn lòng chia sẻ, hỗ trợ khi họ cần.',
                    'Khả năng ngoại giao: Bạn giỏi trong việc giải quyết xung đột, tìm kiếm điểm chung và duy trì sự hài hòa trong các mối quan hệ.',
                    'Hợp tác và hỗ trợ: Bạn thích làm việc nhóm, luôn sẵn lòng giúp đỡ và đặt lợi ích chung lên trên cá nhân.',
                    'Kiên nhẫn và điềm tĩnh: Bạn xử lý tình huống một cách bình tĩnh, không vội vàng và luôn cân nhắc kỹ lưỡng trước khi hành động.',
                ],
                'challenges' => [
                    'Quá nhạy cảm: Bạn có thể dễ bị tổn thương bởi những lời nói hoặc hành động vô tình của người khác.',
                    'Thiếu quyết đoán: Mong muốn làm hài lòng mọi người đôi khi khiến bạn khó đưa ra quyết định dứt khoát.',
                    'Dễ bị lợi dụng: Sự tận tâm và sẵn lòng giúp đỡ có thể khiến bạn trở thành mục tiêu cho những người không chân thành.',
                    'Quên chăm sóc bản thân: Bạn thường ưu tiên nhu cầu của người khác mà quên mất việc lắng nghe và đáp ứng nhu cầu của chính mình.',
                ],
                'advice' => [
                    'Bạn là ánh sáng dịu dàng mang đến sự bình yên cho thế giới xung quanh. Hãy trân trọng và phát huy khả năng thấu cảm, ngoại giao của mình, nhưng đừng quên lắng nghe và đáp ứng nhu cầu của chính bản thân. Khi bạn tìm được sự cân bằng giữa việc chăm sóc người khác và chính mình, bạn sẽ thực sự tỏa sáng và lan tỏa năng lượng tích cực đến mọi nơi bạn đến.',
                ],
                'careerFit' => [
                    'Tư vấn tâm lý, trị liệu.',
                    'Giáo dục, đào tạo.',
                    'Nhân sự, quan hệ công chúng.',
                    'Công tác xã hội, từ thiện.',
                    'Nghệ thuật, thiết kế – nơi bạn có thể thể hiện sự sáng tạo và cảm xúc.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người lãng mạn, chung thủy và luôn sẵn lòng lắng nghe, chia sẻ với đối phương. Bạn tìm kiếm một mối quan hệ dựa trên sự tôn trọng, thấu hiểu và hỗ trợ lẫn nhau. Tuy nhiên, hãy nhớ rằng việc thiết lập ranh giới và chăm sóc bản thân cũng quan trọng không kém trong một mối quan hệ lành mạnh.',
                ]
            ],
            3 => [
                'title' => 'Số Linh Hồn 3',
                'fullText' => 'Bạn có Số Linh Hồn là 3, sâu thẳm trong bạn là khát khao mãnh liệt về sự sáng tạo, biểu đạt và niềm vui sống. Bạn là người yêu thích nghệ thuật, giao tiếp và mong muốn lan tỏa năng lượng tích cực đến mọi người xung quanh. Bạn cảm thấy hạnh phúc nhất khi được thể hiện bản thân một cách tự do và chân thật.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Sáng tạo và nghệ thuật: Bạn có khả năng thiên bẩm trong việc sáng tạo, từ viết lách, hội họa đến âm nhạc và biểu diễn.',
                    'Giao tiếp xuất sắc: Bạn là người truyền đạt ý tưởng một cách lôi cuốn và dễ hiểu, thu hút người nghe bằng sự dí dỏm và chân thành.',
                    'Lạc quan và yêu đời: Bạn luôn nhìn thấy mặt tích cực của cuộc sống và truyền cảm hứng cho người khác bằng năng lượng tích cực của mình.',
                    'Xã giao và thân thiện: Bạn dễ dàng kết nối với mọi người, tạo dựng mối quan hệ tốt đẹp và được nhiều người yêu mến.',
                ],
                'challenges' => [
                    'Thiếu tập trung: Với quá nhiều ý tưởng và đam mê, bạn có thể gặp khó khăn trong việc hoàn thành một dự án cụ thể.',
                    'Tránh né cảm xúc tiêu cực: Bạn có xu hướng che giấu nỗi buồn hoặc lo lắng bằng sự vui vẻ giả tạo, điều này có thể dẫn đến căng thẳng nội tâm.',
                    'Dễ bị phân tâm: Sự yêu thích sự mới mẻ có thể khiến bạn dễ bị xao lãng và khó duy trì sự kiên định trong công việc hoặc mối quan hệ.',
                ],
                'advice' => [
                    'Bạn là ánh sáng rực rỡ mang đến niềm vui và cảm hứng cho thế giới. Hãy trân trọng và phát huy tài năng sáng tạo của mình, đồng thời học cách lắng nghe và chăm sóc bản thân một cách sâu sắc. Khi bạn sống đúng với bản chất của mình, bạn không chỉ hạnh phúc mà còn lan tỏa năng lượng tích cực đến mọi người xung quanh.',
                ],
                'careerFit' => [
                    'Nghệ thuật: viết lách, hội họa, âm nhạc, diễn xuất.',
                    'Truyền thông: báo chí, quảng cáo, truyền hình.',
                    'Giáo dục: giảng dạy, đào tạo kỹ năng mềm.',
                    'Quan hệ công chúng: tổ chức sự kiện, kết nối cộng đồng.',
                    'Người truyền cảm hứng, diễn giả hoặc nhà sáng lập các dự án sáng tạo.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người lãng mạn, nhiệt huyết và luôn tìm cách làm mới mối quan hệ. Bạn cần một người bạn đời hiểu và ủng hộ sự sáng tạo của bạn, đồng thời mang lại sự ổn định và sâu sắc trong cảm xúc. Sự cân bằng giữa tự do và cam kết là chìa khóa để mối quan hệ của bạn phát triển bền vững.',
                ]
            ],
            4 => [
                'title' => 'Số Linh Hồn 4',
                'fullText' => 'Bạn có Số Linh Hồn là 4, sâu thẳm trong bạn là khát khao mãnh liệt về sự ổn định, trật tự và nền tảng vững chắc. Bạn cảm thấy an toàn và hạnh phúc nhất khi mọi thứ xung quanh được tổ chức một cách có hệ thống và logic. Bạn là người tin tưởng vào giá trị của sự chăm chỉ, kỷ luật và trách nhiệm. Bạn không chỉ mong muốn xây dựng một cuộc sống ổn định cho bản thân mà còn muốn tạo ra những giá trị bền vững cho cộng đồng.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Tư duy thực tế và logic: Bạn có khả năng phân tích vấn đề một cách rõ ràng và đưa ra giải pháp hiệu quả.',
                    'Tính tổ chức cao: Bạn giỏi trong việc lập kế hoạch, quản lý thời gian và duy trì trật tự trong công việc cũng như cuộc sống cá nhân.',
                    'Đáng tin cậy và kiên định: Mọi người tin tưởng vào bạn vì bạn luôn giữ lời hứa và hoàn thành nhiệm vụ một cách xuất sắc.',
                    'Tinh thần trách nhiệm: Bạn luôn sẵn lòng gánh vác trách nhiệm và không ngại đối mặt với thử thách để đạt được mục tiêu.',
                ],
                'challenges' => [
                    'Cứng nhắc và bảo thủ: Bạn có thể gặp khó khăn trong việc thích nghi với những thay đổi hoặc ý tưởng mới.',
                    'Áp lực từ sự hoàn hảo: Xu hướng cầu toàn có thể khiến bạn tự tạo áp lực và khó hài lòng với kết quả đạt được.',
                    'Khó biểu đạt cảm xúc: Bạn có thể gặp khó khăn trong việc chia sẻ cảm xúc, dẫn đến hiểu lầm trong các mối quan hệ.',
                    'Thiếu linh hoạt: Sự ưu tiên cho trật tự và kế hoạch có thể khiến bạn bỏ lỡ những cơ hội bất ngờ hoặc trải nghiệm mới mẻ.',
                ],
                'advice' => [
                    'Bạn là người xây dựng nền móng vững chắc cho cuộc sống, không chỉ cho bản thân mà còn cho những người xung quanh. Hãy tiếp tục phát huy sức mạnh từ sự kiên định, tổ chức và trách nhiệm của mình. Đồng thời, hãy học cách linh hoạt và cởi mở hơn với những thay đổi, bởi vì đôi khi, những điều bất ngờ lại mang đến cơ hội phát triển và hạnh phúc mà bạn không ngờ tới.',
                ],
                'careerFit' => [
                    'Kỹ sư, kiến trúc sư.',
                    'Kế toán, tài chính.',
                    'Quản lý dự án, hành chính.',
                    'Pháp lý, luật sư.',
                    'Giáo dục, đào tạo.',
                    'Vai trò lãnh đạo, nơi bạn có thể xây dựng và duy trì các hệ thống hiệu quả.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người trung thành, tận tụy và luôn mong muốn xây dựng một mối quan hệ ổn định, lâu dài. Bạn tìm kiếm một người bạn đời đáng tin cậy, chia sẻ giá trị về sự cam kết và trách nhiệm. Tuy nhiên, hãy nhớ rằng việc thể hiện cảm xúc và sự linh hoạt trong mối quan hệ là điều cần thiết để duy trì sự gắn kết và thấu hiểu lẫn nhau.',
                ]
            ],
            5 => [
                'title' => 'Số Linh Hồn 5',
                'fullText' => 'Bạn có Số Linh Hồn là 5, sâu thẳm trong bạn là khát khao mãnh liệt về tự do, phiêu lưu và trải nghiệm đa dạng. Bạn không thể chịu đựng sự gò bó hay lặp đi lặp lại; thay vào đó, bạn tìm kiếm sự mới mẻ, kích thích và những hành trình không ngừng nghỉ. Bạn là người sống theo nhịp đập của sự thay đổi, luôn hướng tới việc mở rộng chân trời và khám phá những điều chưa biết.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Thích nghi linh hoạt: Bạn dễ dàng thích nghi với môi trường mới, con người mới và hoàn cảnh thay đổi.',
                    'Tư duy cởi mở: Bạn sẵn lòng tiếp nhận ý tưởng mới, văn hóa mới và quan điểm khác biệt.',
                    'Nhiệt huyết và lôi cuốn: Bạn mang đến năng lượng tích cực, truyền cảm hứng cho người khác bằng sự hào hứng và đam mê của mình.',
                    'Giao tiếp xuất sắc: Bạn là người kể chuyện tài ba, dễ dàng kết nối và tạo dựng mối quan hệ với người khác.',
                    'Tư duy sáng tạo: Bạn thường nghĩ ra những ý tưởng mới mẻ, giải pháp đột phá và cách tiếp cận độc đáo.',
                ],
                'challenges' => [
                    'Thiếu kiên nhẫn: Bạn có thể dễ dàng chán nản khi mọi việc trở nên đơn điệu hoặc không còn thú vị.',
                    'Khó cam kết lâu dài: Bạn có xu hướng né tránh trách nhiệm hoặc cam kết dài hạn, đặc biệt khi cảm thấy bị ràng buộc.',
                    'Dễ bị phân tâm: Với nhiều sở thích và đam mê, bạn có thể khó tập trung vào một mục tiêu cụ thể.',
                    'Hành động bốc đồng: Bạn có thể đưa ra quyết định vội vàng mà không cân nhắc kỹ lưỡng hậu quả.',
                    'Tránh né cảm xúc sâu sắc: Bạn có thể ngại đối mặt với cảm xúc tiêu cực hoặc những mối quan hệ đòi hỏi sự sâu sắc và cam kết.',
                ],
                'advice' => [
                    'Bạn là ngọn gió tự do, mang theo năng lượng của sự thay đổi và khám phá. Hãy trân trọng khả năng thích nghi, sự tò mò và tinh thần phiêu lưu của mình. Đồng thời, học cách cân bằng giữa tự do và trách nhiệm, giữa khám phá và cam kết. Khi bạn tìm được sự cân bằng này, bạn sẽ sống một cuộc đời trọn vẹn, đầy màu sắc và ý nghĩa.',
                ],
                'careerFit' => [
                    'Du lịch, lữ hành, hướng dẫn viên.',
                    'Truyền thông, báo chí, phóng viên.',
                    'Nghệ thuật, sáng tạo nội dung, thiết kế.',
                    'Marketing, quảng cáo, quan hệ công chúng.',
                    'Doanh nhân, khởi nghiệp, freelancer.',
                    'Môi trường làm việc linh hoạt, không gò bó, cho phép thể hiện sự sáng tạo và khám phá.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người đam mê, lãng mạn và thích sự mới lạ. Bạn tìm kiếm một người bạn đời có thể đồng hành trong những cuộc phiêu lưu, tôn trọng không gian cá nhân và cùng bạn khám phá thế giới. Tuy nhiên, hãy lưu ý rằng sự ổn định và cam kết cũng là yếu tố quan trọng để xây dựng một mối quan hệ bền vững.',
                ]
            ],
            6 => [
                'title' => 'Số Linh Hồn 6',
                'fullText' => 'Bạn có Số Linh Hồn là 6, sâu thẳm trong bạn là khát khao mãnh liệt về tình yêu, sự chăm sóc và trách nhiệm. Bạn là người luôn mong muốn tạo ra một môi trường ấm áp, hòa thuận và an toàn cho những người xung quanh. Bạn cảm thấy hạnh phúc nhất khi được chăm sóc, bảo vệ và hỗ trợ người khác, đặc biệt là gia đình và cộng đồng. Bạn có xu hướng đặt nhu cầu của người khác lên trên bản thân, với mong muốn mang lại sự hài hòa và ổn định cho mọi người.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Tình yêu thương và lòng trắc ẩn: Bạn có trái tim ấm áp, luôn sẵn lòng lắng nghe và chia sẻ với người khác.',
                    'Tinh thần trách nhiệm cao: Bạn là người đáng tin cậy, luôn hoàn thành nhiệm vụ và cam kết của mình.',
                    'Khả năng tạo dựng môi trường hài hòa: Bạn giỏi trong việc giải quyết xung đột và duy trì sự hòa thuận trong các mối quan hệ.',
                    'Tính cách nuôi dưỡng: Bạn có khả năng chăm sóc và hỗ trợ người khác, giúp họ phát triển và cảm thấy được yêu thương.',
                ],
                'challenges' => [
                    'Quên chăm sóc bản thân: Bạn có thể quá tập trung vào việc giúp đỡ người khác mà bỏ quên nhu cầu và cảm xúc của chính mình.',
                    'Xu hướng kiểm soát: Mong muốn mọi thứ hoàn hảo có thể khiến bạn trở nên kiểm soát và khó chấp nhận sự khác biệt.',
                    'Khó thiết lập ranh giới: Bạn có thể gặp khó khăn trong việc nói "không" và đặt giới hạn cho bản thân, dẫn đến cảm giác quá tải.',
                    'Dễ bị tổn thương: Sự nhạy cảm có thể khiến bạn dễ bị ảnh hưởng bởi lời nói hoặc hành động của người khác.',
                ],
                'advice' => [
                    'Bạn là ánh sáng ấm áp mang đến tình yêu và sự hài hòa cho thế giới. Hãy tiếp tục phát huy lòng trắc ẩn và tinh thần trách nhiệm của mình, nhưng đừng quên chăm sóc và yêu thương chính bản thân. Khi bạn tìm được sự cân bằng giữa việc chăm sóc người khác và bản thân, bạn sẽ sống một cuộc đời trọn vẹn, ý nghĩa và hạnh phúc.',
                ],
                'careerFit' => [
                    'Giáo dục, chăm sóc trẻ em.',
                    'Y tế, điều dưỡng, trị liệu.',
                    'Công tác xã hội, từ thiện.',
                    'Nghệ thuật, thiết kế nội thất.',
                    'Tư vấn, huấn luyện cá nhân.',
                    'Môi trường làm việc cho phép thể hiện sự quan tâm và hỗ trợ người khác.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người tận tụy, trung thành và luôn sẵn lòng hy sinh vì người mình yêu. Bạn tìm kiếm một mối quan hệ ổn định, nơi cả hai cùng chăm sóc và hỗ trợ lẫn nhau. Tuy nhiên, hãy nhớ rằng việc duy trì sự cân bằng giữa cho và nhận, cũng như chăm sóc bản thân, là điều cần thiết để mối quan hệ phát triển bền vững.',
                ]
            ],
            7 => [
                'title' => 'Số Linh Hồn 7',
                'fullText' => 'Bạn có Số Linh Hồn là 7, sâu thẳm trong bạn là khát khao mãnh liệt về tri thức, sự hiểu biết và khám phá những bí ẩn của cuộc sống. Bạn là người thích suy ngẫm, phân tích và luôn tìm kiếm ý nghĩa sâu xa đằng sau mọi hiện tượng. Bạn cảm thấy thoải mái nhất khi được ở trong không gian yên tĩnh, nơi bạn có thể tập trung vào việc nghiên cứu, thiền định và phát triển bản thân.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Tư duy phân tích sắc bén: Bạn có khả năng phân tích và đánh giá thông tin một cách sâu sắc, giúp bạn hiểu rõ bản chất của vấn đề.',
                    'Trực giác mạnh mẽ: Bạn thường cảm nhận được những điều mà người khác không nhận thấy, nhờ vào trực giác nhạy bén của mình.',
                    'Khả năng tập trung cao: Bạn có thể dành thời gian dài để nghiên cứu và tìm hiểu một chủ đề mà bạn đam mê.',
                    'Tính cách độc lập: Bạn thích làm việc một mình và không ngại đối mặt với những thách thức mà không cần sự hỗ trợ từ người khác.',
                ],
                'challenges' => [
                    'Xu hướng cô lập: Sự yêu thích sự yên tĩnh và làm việc độc lập có thể khiến bạn trở nên xa cách với người khác.',
                    'Khó biểu đạt cảm xúc: Bạn có thể gặp khó khăn trong việc chia sẻ cảm xúc của mình, dẫn đến hiểu lầm trong các mối quan hệ.',
                    'Tính cầu toàn: Bạn có xu hướng đặt ra tiêu chuẩn cao cho bản thân và người khác, điều này có thể gây áp lực không cần thiết.',
                    'Thiếu linh hoạt: Bạn có thể trở nên cứng nhắc trong suy nghĩ và khó chấp nhận những quan điểm khác biệt.',
                ],
                'advice' => [
                    'Bạn là người mang trong mình sứ mệnh khám phá và truyền đạt tri thức sâu sắc. Hãy tiếp tục hành trình tìm kiếm sự thật và hiểu biết, nhưng đừng quên kết nối với thế giới xung quanh. Sự cân bằng giữa nội tâm và ngoại giới sẽ giúp bạn phát huy tối đa tiềm năng của mình và sống một cuộc đời ý nghĩa.',
                ],
                'careerFit' => [
                    'Nhà nghiên cứu, nhà khoa học.',
                    'Giáo sư, giảng viên đại học.',
                    'Nhà phân tích dữ liệu, chuyên gia thống kê.',
                    'Nhà văn, nhà báo chuyên sâu.',
                    'Chuyên gia tư vấn, cố vấn chiến lược.',
                    'Môi trường làm việc cho phép tập trung, nghiên cứu sâu và phát triển kiến thức chuyên môn.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người trung thành và sâu sắc. Bạn tìm kiếm một mối quan hệ dựa trên sự hiểu biết lẫn nhau và sự tôn trọng không gian riêng tư. Tuy nhiên, bạn cần học cách mở lòng và chia sẻ cảm xúc để xây dựng mối quan hệ bền vững và sâu sắc hơn.',
                ]
            ],
            8 => [
                'title' => 'Số Linh Hồn 8',
                'fullText' => 'Bạn có Số Linh Hồn là 8, sâu thẳm trong bạn là khát khao mãnh liệt về thành công, quyền lực và sự công nhận. Bạn cảm thấy hạnh phúc nhất khi đạt được mục tiêu lớn, xây dựng sự nghiệp vững chắc và tạo ra ảnh hưởng tích cực trong lĩnh vực bạn theo đuổi. Bạn là người có tầm nhìn xa, luôn hướng đến việc xây dựng một di sản bền vững và có ý nghĩa.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Tinh thần lãnh đạo: Bạn có khả năng dẫn dắt, tổ chức và quản lý hiệu quả, giúp đội nhóm đạt được mục tiêu chung.',
                    'Tư duy chiến lược: Bạn giỏi trong việc lập kế hoạch dài hạn và đưa ra các quyết định quan trọng một cách chính xác.',
                    'Sự kiên định: Bạn không dễ dàng bị lung lay trước khó khăn, luôn kiên trì theo đuổi mục tiêu đến cùng.',
                    'Khả năng tài chính: Bạn có năng lực quản lý tài chính tốt, biết cách đầu tư và sử dụng nguồn lực một cách hiệu quả.',
                ],
                'challenges' => [
                    'Tham công tiếc việc: Bạn có thể quá tập trung vào công việc mà bỏ quên các mối quan hệ cá nhân và sức khỏe.',
                    'Xu hướng kiểm soát: Bạn có thể trở nên cứng nhắc hoặc áp đặt ý kiến lên người khác, gây ra mâu thuẫn không cần thiết.',
                    'Áp lực thành công: Bạn có thể tự tạo áp lực lớn cho bản thân, dẫn đến căng thẳng và mất cân bằng trong cuộc sống.',
                    'Khó chia sẻ cảm xúc: Bạn có thể gặp khó khăn trong việc thể hiện cảm xúc, khiến người khác cảm thấy bạn lạnh lùng hoặc xa cách.',
                ],
                'advice' => [
                    'Bạn là người mang trong mình năng lượng của sự thành công và quyền lực. Hãy sử dụng sức mạnh này một cách khôn ngoan, không chỉ để đạt được mục tiêu cá nhân mà còn để tạo ra ảnh hưởng tích cực cho cộng đồng. Đừng quên rằng, thành công thực sự đến từ sự cân bằng giữa công việc, các mối quan hệ và sự phát triển bản thân. Khi bạn học cách chia sẻ, lắng nghe và thấu hiểu, bạn sẽ không chỉ đạt được thành tựu mà còn tìm thấy hạnh phúc đích thực trong cuộc sống.',
                ],
                'careerFit' => [
                    'Quản lý, điều hành doanh nghiệp.',
                    'Tài chính, đầu tư, ngân hàng.',
                    'Luật pháp, chính trị.',
                    'Bất động sản, xây dựng.',
                    'Khởi nghiệp, sáng lập doanh nghiệp.',
                    'Môi trường làm việc thách thức, nơi bạn có thể phát huy tối đa khả năng lãnh đạo.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người trung thành và sẵn sàng bảo vệ người mình yêu. Bạn tìm kiếm một mối quan hệ ổn định, nơi cả hai cùng hỗ trợ và phát triển. Tuy nhiên, hãy chú ý đến việc cân bằng giữa công việc và cuộc sống cá nhân, cũng như học cách chia sẻ cảm xúc để mối quan hệ trở nên sâu sắc và bền vững hơn.',
                ]
            ],
            9 => [
                'title' => 'Số Linh Hồn 9',
                'fullText' => 'Bạn có Số Linh Hồn là 9, sâu thẳm trong bạn là khát khao mãnh liệt về phụng sự nhân loại, lan tỏa yêu thương và tạo ra sự thay đổi tích cực. Bạn cảm thấy hạnh phúc nhất khi được giúp đỡ người khác, chia sẻ tình yêu thương và góp phần xây dựng một thế giới tốt đẹp hơn. Bạn là người có trái tim rộng mở, luôn sẵn lòng hy sinh vì lợi ích chung và không ngừng tìm kiếm ý nghĩa sâu xa trong cuộc sống.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Lòng trắc ẩn sâu sắc: Bạn có khả năng thấu hiểu và đồng cảm với nỗi đau của người khác, luôn sẵn lòng lắng nghe và chia sẻ.',
                    'Tư duy nhân văn: Bạn nhìn nhận cuộc sống với cái nhìn rộng mở, luôn hướng đến sự công bằng, bình đẳng và hòa bình.',
                    'Tinh thần hy sinh: Bạn sẵn sàng đặt lợi ích của người khác lên trên bản thân, không ngại hy sinh để mang lại hạnh phúc cho cộng đồng.',
                    'Sáng tạo và nghệ thuật: Bạn có khả năng biểu đạt cảm xúc thông qua nghệ thuật, truyền tải thông điệp yêu thương và hy vọng đến mọi người.',
                ],
                'challenges' => [
                    'Quên chăm sóc bản thân: Bạn có thể quá tập trung vào việc giúp đỡ người khác mà bỏ quên nhu cầu và cảm xúc của chính mình.',
                    'Dễ bị tổn thương: Sự nhạy cảm có thể khiến bạn dễ bị ảnh hưởng bởi lời nói hoặc hành động của người khác.',
                    'Lý tưởng hóa quá mức: Bạn có thể đặt ra những kỳ vọng không thực tế, dẫn đến thất vọng khi mọi thứ không diễn ra như mong muốn.',
                    'Khó thiết lập ranh giới: Bạn có thể gặp khó khăn trong việc nói "không" và đặt giới hạn cho bản thân, dẫn đến cảm giác quá tải.',
                ],
                'advice' => [
                    'Bạn là ánh sáng ấm áp mang đến tình yêu và sự hài hòa cho thế giới. Hãy tiếp tục phát huy lòng trắc ẩn và tinh thần phụng sự của mình, nhưng đừng quên chăm sóc và yêu thương chính bản thân. Khi bạn tìm được sự cân bằng giữa việc chăm sóc người khác và bản thân, bạn sẽ sống một cuộc đời trọn vẹn, ý nghĩa và hạnh phúc.',
                ],
                'careerFit' => [
                    'Công tác xã hội, từ thiện.',
                    'Giáo dục, đào tạo.',
                    'Y tế, chăm sóc sức khỏe.',
                    'Nghệ thuật, sáng tạo nội dung.',
                    'Tư vấn, trị liệu tâm lý.',
                    'Môi trường làm việc cho phép thể hiện lòng trắc ẩn, sự sáng tạo và đóng góp tích cực cho cộng đồng.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người tận tụy, trung thành và luôn sẵn lòng hy sinh vì người mình yêu. Bạn tìm kiếm một mối quan hệ sâu sắc, nơi cả hai cùng chia sẻ giá trị về tình yêu thương và sự phụng sự. Tuy nhiên, hãy nhớ rằng việc duy trì sự cân bằng giữa cho và nhận, cũng như chăm sóc bản thân, là điều cần thiết để mối quan hệ phát triển bền vững.',
                ]
            ],
            11 => [
                'title' => 'Số Linh Hồn 11',
                'fullText' => 'Bạn có Số Linh Hồn là 11, sâu thẳm trong bạn là khát khao mãnh liệt về kết nối tâm linh, truyền cảm hứng và khám phá chân lý sâu xa của cuộc sống. Bạn là người mang trong mình năng lượng của một "người truyền ánh sáng", luôn tìm kiếm sự khai sáng và mong muốn chia sẻ những hiểu biết sâu sắc với thế giới. Sự nhạy cảm và trực giác mạnh mẽ giúp bạn cảm nhận được những điều mà người khác có thể bỏ lỡ, khiến bạn trở thành người hướng dẫn tinh thần cho những ai đang tìm kiếm ý nghĩa cuộc sống.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [],
                'strengths' => [
                    'Trực giác sâu sắc: Bạn có khả năng cảm nhận và hiểu được cảm xúc, suy nghĩ của người khác một cách tự nhiên.',
                    'Tầm nhìn tâm linh: Bạn thường có những cái nhìn sâu sắc về cuộc sống và khả năng truyền đạt những hiểu biết đó một cách truyền cảm.',
                    'Sáng tạo và nghệ thuật: Bạn có khả năng biểu đạt cảm xúc và ý tưởng thông qua nghệ thuật, viết lách hoặc các hình thức sáng tạo khác.',
                    'Khả năng truyền cảm hứng: Bạn có thể khơi dậy niềm tin và động lực trong người khác, giúp họ tìm thấy con đường của riêng mình.',
                ],
                'challenges' => [
                    'Nhạy cảm quá mức: Sự nhạy cảm cao có thể khiến bạn dễ bị ảnh hưởng bởi năng lượng tiêu cực xung quanh.',
                    'Tự nghi ngờ: Bạn có thể nghi ngờ khả năng của chính mình, dẫn đến việc không dám thể hiện bản thân một cách đầy đủ.',
                    'Khó cân bằng giữa tâm linh và thực tế: Bạn có thể bị cuốn vào thế giới nội tâm mà quên mất việc kết nối với thực tế hàng ngày.',
                    'Áp lực từ kỳ vọng cao: Bạn có thể đặt ra những tiêu chuẩn quá cao cho bản thân, dẫn đến cảm giác thất vọng khi không đạt được.',
                ],
                'advice' => [
                    'Bạn là ngọn đèn soi sáng, mang đến hy vọng và sự khai sáng cho thế giới. Hãy tin tưởng vào trực giác và khả năng của mình, đồng thời học cách cân bằng giữa thế giới tâm linh và thực tế. Khi bạn sống đúng với bản chất của mình, bạn sẽ không chỉ tìm thấy hạnh phúc mà còn giúp người khác tìm thấy ánh sáng trong cuộc sống của họ.',
                ],
                'careerFit' => [
                    'Giáo dục, giảng dạy, huấn luyện.',
                    'Tư vấn tâm lý, trị liệu.',
                    'Nghệ thuật, viết lách, âm nhạc.',
                    'Lĩnh vực tâm linh, tôn giáo, chữa lành.',
                    'Diễn thuyết, truyền thông, truyền cảm hứng.',
                    'Môi trường làm việc cho phép thể hiện sự sáng tạo, kết nối với người khác và theo đuổi mục tiêu tâm linh.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người sâu sắc, tận tụy và tìm kiếm một mối quan hệ có chiều sâu tâm linh. Bạn mong muốn một người bạn đời có thể đồng hành cùng bạn trên hành trình khám phá bản thân và thế giới tâm linh. Tuy nhiên, hãy nhớ rằng việc duy trì sự cân bằng giữa thế giới nội tâm và thực tế là cần thiết để xây dựng một mối quan hệ bền vững.',
                ]
            ],
            22 => [
                'title' => 'Số Linh Hồn 22',
                'fullText' => 'Bạn có Số Linh Hồn là 22 - con số hiếm có, được biết đến với cái tên "Master Builder" - Người Kiến Tạo Vĩ Đại. Sâu thẳm trong bạn là khát khao mãnh liệt về xây dựng những công trình vĩ đại và tạo ra ảnh hưởng lâu dài. Bạn là người có tầm nhìn xa, khả năng biến những ý tưởng lớn thành hiện thực và mong muốn để lại dấu ấn bền vững cho thế giới.',
                'calculation' => 'Tính từ tổng giá trị các nguyên âm trong họ tên',
                'keyTraits' => [
                    'Khát khao xây dựng công trình vĩ đại.',
                    'Tầm nhìn xa và khả năng hiện thực hóa.',
                    'Mong muốn tạo ảnh hưởng lâu dài.',
                    'Để lại dấu ấn bền vững cho thế giới.',
                ],
                'strengths' => [
                    'Tầm nhìn chiến lược: Bạn sở hữu khả năng nhìn thấy bức tranh tổng thể, từ đó lập kế hoạch dài hạn và đầy tham vọng.',
                    'Khả năng hiện thực hóa: Không chỉ dừng lại ở ý tưởng, bạn có năng lực biến chúng thành hiện thực thông qua hành động cụ thể và kỷ luật cao.',
                    'Lãnh đạo và ảnh hưởng: Với sức ảnh hưởng lớn, bạn có thể dẫn dắt và truyền cảm hứng cho người khác cùng theo đuổi mục tiêu chung.',
                    'Tinh thần trách nhiệm: Bạn cảm thấy có trách nhiệm với cộng đồng và thường hướng đến những mục tiêu phục vụ lợi ích chung.',
                ],
                'challenges' => [
                    'Áp lực thành công: Khát khao thành tựu lớn đôi khi gây ra áp lực và căng thẳng cho bạn, khiến bạn dễ kiệt sức.',
                    'Xu hướng kiểm soát: Đôi khi bạn trở nên cứng nhắc hoặc áp đặt ý kiến của mình lên người khác.',
                    'Khó chia sẻ cảm xúc: Bạn có thể gặp khó khăn trong việc thể hiện cảm xúc, khiến người khác cảm thấy bạn lạnh lùng.',
                    'Sợ thất bại: Nỗi sợ thất bại có thể khiến bạn do dự hoặc trì hoãn các quyết định quan trọng.',
                ],
                'advice' => [
                    'Lời nhắn từ vũ trụ dành cho bạn: Bạn được ban tặng sức mạnh của Master Builder - con số 22 hiếm có và quyền năng. Đừng để áp lực của sự vĩ đại làm bạn quên đi niềm vui trong từng bước nhỏ. Hãy nhớ rằng, những công trình vĩ đại nhất cũng được xây dựng từ những viên gạch nhỏ bé. Học cách chia sẻ quyền lực và lắng nghe ý kiến của người khác. Sự hợp tác sẽ giúp bạn xây dựng những thành tựu còn vĩ đại hơn những gì bạn có thể làm một mình. Hãy cân bằng giữa tham vọng và lòng từ bi, giữa sức mạnh và sự dịu dàng. Đừng để nỗi sợ thất bại cản trở bạn. Mỗi thất bại là một bài học quý giá trên con đường xây dựng di sản của bạn. Vũ trụ tin tưởng vào khả năng của bạn - hãy tin tưởng vào chính mình và bắt tay vào hành động.',
                ],
                'careerFit' => [
                    'Quản lý dự án quy mô lớn, điều hành doanh nghiệp.',
                    'Kiến trúc sư, kỹ sư xây dựng công trình lớn.',
                    'Chính trị gia, nhà hoạch định chính sách.',
                    'Giáo dục đại học, đào tạo lãnh đạo cấp cao.',
                    'Tư vấn chiến lược, phát triển tổ chức quốc tế.',
                    'Nhà đầu tư, phát triển bất động sản.',
                    'CEO, founder của startup có tầm nhìn xa.',
                ],
                'loveGuidance' => [
                    'Trong tình yêu, bạn là người trung thành và tận tụy. Bạn tìm kiếm một mối quan hệ ổn định, nơi cả hai cùng hỗ trợ và phát triển. Tuy nhiên, bạn cần chú ý cân bằng giữa công việc và cuộc sống cá nhân, tránh để tham vọng lấn át tình cảm. Học cách chia sẻ cảm xúc và dành thời gian chất lượng cho người bạn yêu sẽ giúp mối quan hệ của bạn sâu sắc và bền vững hơn.',
                ]
            ]
        ];
    }

    /**
     * Get personality interpretations data from source code
     */
    public static function getPersonalityInterpretationsData()
    {
        return [
            1 => [
                'title' => 'Số Tính Cách 1',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Người có Số Tính Cách là 1 thường toát ra khí chất độc lập, tự tin và đầy quyết đoán. Trong mắt người khác, bạn là người mạnh mẽ, không ngại đi trước, và luôn mang năng lượng của một người dẫn đầu. Dù ở bất kỳ môi trường nào, bạn cũng thường tạo ra dấu ấn riêng và thích khẳng định bản thân bằng hành động cụ thể. Bạn có xu hướng thích kiểm soát tình huống, chủ động trong giao tiếp và thường không ngần ngại nói lên suy nghĩ của mình. Từ cách bạn ăn mặc, nói chuyện, cho đến cách phản ứng – tất cả đều thể hiện một phong thái tự chủ và rõ ràng.',
                'career' => 'Bạn phù hợp với vai trò đòi hỏi sự độc lập, sáng tạo hoặc lãnh đạo. Sự quyết liệt và chủ động của bạn giúp bạn xử lý công việc nhanh gọn, rõ mục tiêu và biết hướng đến kết quả. Tuy nhiên, bạn cần lưu ý rằng: Tinh thần cạnh tranh cao có thể khiến bạn trở nên cứng nhắc. Bạn cần học cách lắng nghe người khác nhiều hơn, nhất là khi làm việc nhóm. Tránh rơi vào cái bẫy "tự mình làm hết" vì bạn có xu hướng không tin tưởng người khác đủ.',
                'relationships' => 'Người có Personality 1 thường chủ động, chung thủy, và bảo vệ người mình yêu thương. Tuy nhiên, bạn có thể dễ trở nên kiểm soát hoặc áp đặt nếu cảm thấy người kia không đủ vững vàng. Bạn cần một đối phương đủ linh hoạt, sẵn sàng ủng hộ nhưng không làm lu mờ cái tôi của bạn. Sự cân bằng giữa cá tính mạnh và tinh tế trong giao tiếp là điều bạn cần rèn luyện để giữ các mối quan hệ bền lâu.',
                'challenges' => [
                    'Tính kiểm soát cao: khiến người khác cảm thấy áp lực hoặc bị phán xét.',
                    'Ít kiên nhẫn: dễ nóng nảy nếu mọi thứ không đi đúng kế hoạch.',
                    'Dễ bị hiểu lầm là lạnh lùng hoặc kiêu ngạo, trong khi thực tế bạn chỉ đang tập trung vào mục tiêu.'
                ],
                'advice' => [
                    'Học cách trao quyền và tin tưởng vào người khác.',
                    'Tập trung vào lắng nghe và phản hồi mềm mại, thay vì ra lệnh hoặc bác bỏ.',
                    'Dành thời gian để chậm lại và cảm nhận, tránh cuốn vào nhịp độ quá nhanh dễ làm bạn mất kết nối với cảm xúc thật.'
                ]
            ],
            2 => [
                'title' => 'Số Tính Cách 2',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Bạn mang Số Tính Cách là 2 thường được người khác cảm nhận là người dịu dàng, tinh tế và dễ gần. Bạn toát ra năng lượng của sự hòa giải, thấu hiểu và hợp tác. Trong mắt người khác, bạn là người đáng tin cậy, biết lắng nghe và luôn tìm cách giữ gìn sự cân bằng trong mọi mối quan hệ.',
                'career' => 'Bạn phù hợp với những vai trò yêu cầu sự hợp tác, giao tiếp khéo léo và giải quyết xung đột. Các lĩnh vực như tư vấn, giáo dục, ngoại giao, y tế hoặc nghệ thuật sẽ là môi trường lý tưởng để bạn phát huy khả năng của mình. Bạn không thích cạnh tranh gay gắt mà ưa chuộng môi trường làm việc hòa thuận và hỗ trợ lẫn nhau.',
                'relationships' => 'Trong các mối quan hệ, bạn là người trung thành, tận tâm và nhạy cảm với cảm xúc của đối phương. Bạn luôn cố gắng duy trì sự hòa hợp và tránh xung đột. Tuy nhiên, đôi khi bạn có thể trở nên quá nhạy cảm hoặc dễ bị tổn thương nếu không nhận được sự quan tâm đúng mức. Việc thiết lập ranh giới rõ ràng và chăm sóc bản thân là điều quan trọng để duy trì mối quan hệ lành mạnh.',
                'challenges' => [
                    'Thiếu tự tin: Bạn có thể nghi ngờ giá trị bản thân và tìm kiếm sự xác nhận từ người khác.',
                    'Tránh né xung đột: Sự sợ hãi đối đầu có thể khiến bạn kìm nén cảm xúc và khó thể hiện nhu cầu cá nhân.',
                    'Quá nhạy cảm: Bạn dễ bị tổn thương bởi những lời chỉ trích hoặc thiếu sự công nhận.'
                ],
                'advice' => [
                    'Xây dựng lòng tự trọng: Học cách đánh giá cao bản thân và tin tưởng vào khả năng của mình.',
                    'Thiết lập ranh giới: Biết nói "không" khi cần thiết và bảo vệ không gian cá nhân.',
                    'Thể hiện cảm xúc một cách lành mạnh: Chia sẻ suy nghĩ và cảm xúc của bạn một cách trung thực và khéo léo.'
                ]
            ],
            3 => [
                'title' => 'Số Tính Cách 3',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Người mang Số Tính Cách là 3 thường được người khác cảm nhận là người sáng tạo, hoạt bát và quyến rũ. Bạn toát ra năng lượng của sự vui vẻ, lạc quan và giao tiếp tốt. Trong mắt người khác, bạn là người dễ gần, thú vị và thường là tâm điểm của các cuộc trò chuyện.',
                'career' => 'Bạn phù hợp với những vai trò yêu cầu sự sáng tạo, giao tiếp và tương tác xã hội. Các lĩnh vực như nghệ thuật, truyền thông, giải trí, giáo dục hoặc quảng cáo sẽ là môi trường lý tưởng để bạn phát huy khả năng của mình. Bạn có khả năng truyền cảm hứng và kết nối với người khác một cách tự nhiên.',
                'relationships' => 'Trong các mối quan hệ, bạn là người ấm áp, hài hước và dễ thương. Bạn mang lại niềm vui và sự tích cực cho người khác. Tuy nhiên, đôi khi bạn có thể trở nên thiếu kiên nhẫn hoặc thiếu tập trung nếu mối quan hệ trở nên đơn điệu. Việc duy trì sự mới mẻ và khám phá cùng nhau sẽ giúp mối quan hệ của bạn phát triển bền vững.',
                'challenges' => [
                    'Thiếu kiên nhẫn: Bạn có thể dễ dàng mất hứng thú nếu không thấy sự tiến triển nhanh chóng.',
                    'Thiếu tập trung: Sự tò mò và ham học hỏi có thể khiến bạn dễ bị phân tâm.',
                    'Tránh né cảm xúc tiêu cực: Bạn có xu hướng né tránh những cảm xúc khó chịu thay vì đối mặt và giải quyết chúng.'
                ],
                'advice' => [
                    'Rèn luyện sự kiên nhẫn: Học cách chờ đợi và đánh giá tình huống một cách toàn diện trước khi hành động.',
                    'Tập trung vào mục tiêu: Xác định rõ ràng mục tiêu và lập kế hoạch cụ thể để đạt được chúng.',
                    'Đối mặt với cảm xúc: Học cách chấp nhận và xử lý các cảm xúc tiêu cực một cách lành mạnh.'
                ]
            ],
            4 => [
                'title' => 'Số Tính Cách 4',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Bạn có Số Tính Cách là 4 thường được nhận diện là người ổn định, có tổ chức và đáng tin cậy. Bạn toát ra phong thái của một người nghiêm túc, thực tế và chăm chỉ, khiến người khác cảm thấy an tâm khi làm việc hay đồng hành cùng bạn. Trong mắt người xung quanh, bạn đại diện cho sự kiên định, trung thành và luôn giữ vững cam kết. Bạn không thích sự hỗn loạn hay tùy hứng. Thay vào đó, bạn đề cao trật tự, kỷ luật và sự chính xác. Dù không phải là người ưa phô trương, bạn lại được tin tưởng vì hành động nhất quán và tinh thần trách nhiệm cao.',
                'career' => 'Bạn là người làm việc rất có kế hoạch, thích quy trình rõ ràng và luôn hoàn thành nhiệm vụ với tinh thần trách nhiệm cao. Các công việc phù hợp với bạn bao gồm: kế toán, kỹ thuật, luật, quản trị, giáo dục, hoặc bất kỳ lĩnh vực nào yêu cầu sự chính xác, tính kỷ luật và ổn định. Bạn không chỉ là người thực thi tốt, mà còn biết cách xây dựng nền tảng bền vững cho tập thể. Đồng nghiệp xem bạn là người có thể dựa vào khi cần sự chắc chắn và hiệu quả.',
                'relationships' => 'Trong các mối quan hệ, bạn thể hiện là người trung thực, tận tụy và thực tế. Bạn không phô trương, nhưng luôn thể hiện tình cảm qua hành động cụ thể và bền bỉ. Đối phương có thể cảm nhận được sự an toàn và ổn định khi ở cạnh bạn. Tuy nhiên, đôi khi bạn có thể bị cho là khô khan hoặc quá nghiêm túc nếu không biết cách cân bằng giữa trách nhiệm và cảm xúc. Người phù hợp với bạn là người hiểu rằng tình cảm cũng là một cam kết lâu dài, chứ không chỉ là sự lãng mạn ngắn hạn.',
                'challenges' => [
                    'Cứng nhắc: Bạn có thể gặp khó khăn khi đối diện với thay đổi hoặc những tình huống thiếu kiểm soát.',
                    'Bảo thủ: Có xu hướng khép kín và bám vào lối cũ, khó tiếp thu điều mới.',
                    'Quá trọng trách nhiệm: Dễ bỏ quên nhu cầu cá nhân vì quá chú tâm vào việc "phải làm đúng".'
                ],
                'advice' => [
                    'Học cách linh hoạt và đón nhận sự thay đổi như một phần của cuộc sống.',
                    'Dành thời gian cho sự sáng tạo, vui chơi, hoặc kết nối cảm xúc – để làm mềm đi sự nghiêm khắc nội tâm.',
                    'Nhớ rằng: không phải lúc nào làm đúng cũng tốt, đôi khi "đủ" là vừa đủ.'
                ]
            ],
            5 => [
                'title' => 'Số Tính Cách 5',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Bạn mang Số Tính Cách là 5 thường được người khác cảm nhận là người năng động, linh hoạt và thích khám phá. Bạn toát ra năng lượng của sự tự do, phiêu lưu và thích nghi nhanh. Trong mắt người khác, bạn là người thú vị, dễ gần và luôn mang đến sự mới mẻ trong mọi tình huống.',
                'career' => 'Bạn phù hợp với những vai trò yêu cầu sự sáng tạo, giao tiếp và thích ứng nhanh. Các lĩnh vực như truyền thông, du lịch, giải trí, bán hàng hoặc tiếp thị sẽ là môi trường lý tưởng để bạn phát huy khả năng của mình. Bạn không thích công việc đơn điệu mà ưa chuộng môi trường làm việc đa dạng và đầy thử thách.',
                'relationships' => 'Trong các mối quan hệ, bạn là người thú vị, tự do và khó đoán. Bạn mang lại sự hứng khởi và năng lượng tích cực cho đối phương. Tuy nhiên, đôi khi bạn có thể trở nên thiếu kiên nhẫn hoặc khó cam kết nếu mối quan hệ trở nên quá ràng buộc. Việc duy trì sự tự do cá nhân và khám phá cùng nhau sẽ giúp mối quan hệ của bạn phát triển bền vững.',
                'challenges' => [
                    'Thiếu kiên nhẫn: Bạn có thể dễ dàng mất hứng thú nếu không thấy sự tiến triển nhanh chóng.',
                    'Thiếu tập trung: Sự tò mò và ham học hỏi có thể khiến bạn dễ bị phân tâm.',
                    'Tránh né cam kết: Bạn có xu hướng né tránh những cam kết lâu dài, điều này có thể ảnh hưởng đến sự ổn định trong cuộc sống.'
                ],
                'advice' => [
                    'Rèn luyện sự kiên nhẫn: Học cách chờ đợi và đánh giá tình huống một cách toàn diện trước khi hành động.',
                    'Tập trung vào mục tiêu: Xác định rõ ràng mục tiêu và lập kế hoạch cụ thể để đạt được chúng.',
                    'Đối mặt với cam kết: Học cách chấp nhận và thực hiện các cam kết một cách có trách nhiệm.'
                ]
            ],
            6 => [
                'title' => 'Số Tính Cách 6',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Bạn có Số Tính Cách là 6 thường mang lại cảm giác ấm áp, chu đáo và đáng tin cậy. Trong mắt người khác, bạn là người quan tâm đến người xung quanh, luôn sẵn lòng giúp đỡ và đặt trách nhiệm lên hàng đầu. Bạn toát ra khí chất của một người bảo vệ, luôn cố gắng mang lại sự hòa hợp và bình yên cho môi trường xung quanh mình. Bạn có khả năng kết nối cảm xúc sâu sắc, thường thu hút người khác nhờ sự chân thành và đáng mến. Từ cách bạn hành xử đến phong thái bên ngoài, mọi người cảm nhận bạn là người có thể dựa vào trong lúc khó khăn.',
                'career' => 'Bạn phù hợp với các công việc đòi hỏi sự chăm sóc, hỗ trợ, tổ chức và trách nhiệm. Các lĩnh vực như giáo dục, y tế, trị liệu, công tác xã hội, quản lý hoặc nghệ thuật gia đình là nơi bạn phát huy tối đa thế mạnh. Bạn không chỉ giỏi duy trì trật tự mà còn xây dựng bầu không khí gắn bó giữa các thành viên trong tập thể. Tinh thần trách nhiệm cao và cảm xúc tinh tế là lý do bạn thường được giao những vai trò quan trọng trong nhóm.',
                'relationships' => 'Bạn là người bạn đời tận tụy, chân thành, giàu cảm xúc và đầy bảo vệ. Bạn rất nhạy với cảm xúc của người thân, luôn tìm cách làm họ cảm thấy được yêu thương và chăm sóc. Tuy nhiên, đôi khi bạn có thể trở nên quá hy sinh, quên mất bản thân vì muốn lo lắng cho người khác. Bạn cũng cần đề phòng xu hướng can thiệp quá mức vào chuyện của người thân với danh nghĩa "muốn điều tốt cho họ".',
                'challenges' => [
                    'Quá trách nhiệm: dễ khiến bản thân kiệt sức, đặc biệt khi gánh quá nhiều việc của người khác.',
                    'Xu hướng kiểm soát nhẹ nhàng: thường muốn "lo hết" cho người khác, đôi khi gây ngột ngạt.',
                    'Sợ làm người khác buồn: dễ chịu tổn thương nếu cảm thấy mình không được trân trọng như kỳ vọng.'
                ],
                'advice' => [
                    'Học cách chăm sóc bản thân trước khi chăm sóc người khác.',
                    'Đặt ranh giới lành mạnh: giúp bạn duy trì sự cân bằng giữa yêu thương và không đánh mất mình.',
                    'Chấp nhận sự không hoàn hảo: đôi khi người bạn yêu cần tự vấp ngã để trưởng thành – bạn không thể gánh hộ hết mọi điều.'
                ]
            ],
            7 => [
                'title' => 'Số Tính Cách 7',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Bạn mang Số Tính Cách là 7 thường được người khác cảm nhận là người bí ẩn, sâu sắc và trí tuệ. Bạn toát ra năng lượng của sự trầm lặng, suy tư và tìm kiếm chân lý. Trong mắt người khác, bạn là người độc lập, trực giác mạnh mẽ và có chiều sâu tâm hồn. Bạn có xu hướng hướng nội, thích dành thời gian để suy ngẫm và khám phá thế giới nội tâm. Sự tò mò trí tuệ và khả năng phân tích sâu sắc giúp bạn trở thành người tìm kiếm sự thật và hiểu biết sâu rộng.',
                'career' => 'Bạn phù hợp với những công việc yêu cầu tư duy phân tích, nghiên cứu và khám phá chiều sâu. Các lĩnh vực như khoa học, triết học, tâm lý học, nghiên cứu, viết lách hoặc tâm linh sẽ là môi trường lý tưởng để bạn phát huy khả năng của mình. Bạn thích làm việc độc lập, có khả năng tập trung cao và thường đạt được thành tựu xuất sắc khi được làm việc theo cách riêng của mình. Tuy nhiên, môi trường làm việc quá ồn ào hoặc đòi hỏi giao tiếp xã hội nhiều có thể khiến bạn cảm thấy mệt mỏi.',
                'relationships' => 'Trong các mối quan hệ, bạn là người chân thành, trung thành và sâu sắc. Tuy nhiên, bạn có thể khó mở lòng và dễ cảm thấy bị hiểu lầm nếu đối phương không đủ kiên nhẫn và tinh tế. Bạn cần một người bạn đời thấu hiểu, tôn trọng không gian riêng tư và cùng chia sẻ những giá trị sâu sắc trong cuộc sống. Bạn có xu hướng tránh né cảm xúc tiêu cực và ít thể hiện cảm xúc, điều này có thể gây ra sự xa cách trong mối quan hệ nếu không được cân bằng.',
                'challenges' => [
                    'Quá hướng nội: Dễ dẫn đến cô lập và khó kết nối với người khác.',
                    'Nghi ngờ và phân tích quá mức: Có thể khiến bạn mất đi sự tin tưởng và khó đưa ra quyết định.',
                    'Tránh né cảm xúc: Dễ dẫn đến ức chế cảm xúc và khó khăn trong việc thể hiện bản thân.'
                ],
                'advice' => [
                    'Học cách mở lòng: Dành thời gian để kết nối với người khác và chia sẻ cảm xúc một cách chân thành.',
                    'Cân bằng giữa trí tuệ và cảm xúc: Kết hợp tư duy phân tích với sự thấu cảm để hiểu và kết nối sâu sắc hơn với thế giới xung quanh.',
                    'Thực hành thiền định và chánh niệm: Giúp bạn giữ vững sự bình an nội tâm và phát triển trực giác.'
                ]
            ],
            8 => [
                'title' => 'Số Tính Cách 8',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Bạn mang Số Tính Cách là 8 thường được người khác cảm nhận là người mạnh mẽ, quyết đoán và có khả năng lãnh đạo tự nhiên. Bạn toát ra năng lượng của sự tự tin, tham vọng và khả năng kiểm soát. Trong mắt người khác, bạn là người đáng tin cậy, có tầm nhìn xa và luôn hướng tới thành công. Bạn có xu hướng tập trung vào mục tiêu, kiên trì và sẵn sàng đối mặt với thử thách để đạt được những gì mình mong muốn. Sự quyết đoán và khả năng tổ chức giúp bạn trở thành người dẫn dắt và truyền cảm hứng cho người khác.',
                'career' => 'Bạn phù hợp với những vai trò yêu cầu khả năng lãnh đạo, quản lý và ra quyết định chiến lược. Các lĩnh vực như kinh doanh, tài chính, luật, chính trị hoặc quản trị cấp cao sẽ là môi trường lý tưởng để bạn phát huy khả năng của mình. Bạn có khả năng xây dựng và duy trì hệ thống hiệu quả, đưa ra quyết định nhanh chóng và đạt được kết quả vượt trội. Tuy nhiên, bạn cần chú ý đến việc cân bằng giữa công việc và cuộc sống cá nhân để tránh bị kiệt sức.',
                'relationships' => 'Trong các mối quan hệ, bạn là người trung thành, bảo vệ và sẵn sàng hỗ trợ người thân. Bạn mong muốn xây dựng một mối quan hệ ổn định, bền vững và có sự tôn trọng lẫn nhau. Tuy nhiên, đôi khi bạn có thể trở nên quá kiểm soát hoặc khó mở lòng, điều này có thể gây ra sự căng thẳng trong mối quan hệ. Việc lắng nghe và chia sẻ cảm xúc sẽ giúp bạn xây dựng mối quan hệ sâu sắc và hài hòa hơn.',
                'challenges' => [
                    'Quá tập trung vào thành công vật chất: Dễ dẫn đến việc bỏ qua các khía cạnh tinh thần và cảm xúc.',
                    'Tính kiểm soát cao: Có thể gây ra xung đột trong mối quan hệ cá nhân và công việc.',
                    'Khó chấp nhận thất bại: Dễ bị ảnh hưởng tiêu cực khi không đạt được mục tiêu.'
                ],
                'advice' => [
                    'Cân bằng giữa công việc và cuộc sống cá nhân: Dành thời gian cho gia đình, bạn bè và bản thân.',
                    'Phát triển trí tuệ cảm xúc: Học cách nhận diện và quản lý cảm xúc của mình và người khác.',
                    'Chấp nhận và học hỏi từ thất bại: Xem thất bại là cơ hội để trưởng thành và cải thiện.'
                ]
            ],
            9 => [
                'title' => 'Số Tính Cách 9',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Người mang Số Tính Cách là 9 thường được người khác cảm nhận là người giàu lòng trắc ẩn, vị tha và có tầm nhìn rộng. Bạn toát ra năng lượng của sự kết thúc chu kỳ, trí tuệ sâu sắc và mong muốn phục vụ nhân loại. Trong mắt người khác, bạn là người đáng kính, có phẩm chất lãnh đạo tự nhiên và luôn hướng tới việc làm cho thế giới trở nên tốt đẹp hơn. Bạn có xu hướng hướng nội, suy tư và tìm kiếm ý nghĩa sâu xa trong cuộc sống. Sự nhạy cảm và trực giác mạnh mẽ giúp bạn hiểu và đồng cảm sâu sắc với những người xung quanh.',
                'career' => 'Bạn phù hợp với những công việc yêu cầu sự đồng cảm, sáng tạo và mong muốn phục vụ cộng đồng. Các lĩnh vực như giáo dục, y tế, công tác xã hội, nghệ thuật hoặc tôn giáo sẽ là môi trường lý tưởng để bạn phát huy khả năng của mình. Bạn có khả năng truyền cảm hứng, dẫn dắt và tạo ra sự thay đổi tích cực trong cộng đồng. Tuy nhiên, bạn cần chú ý đến việc cân bằng giữa việc giúp đỡ người khác và chăm sóc bản thân để tránh bị kiệt sức.',
                'relationships' => 'Trong các mối quan hệ, bạn là người chân thành, trung thành và sẵn lòng hy sinh vì người mình yêu thương. Bạn mong muốn xây dựng một mối quan hệ sâu sắc, ý nghĩa và có sự kết nối tâm hồn. Tuy nhiên, đôi khi bạn có thể trở nên quá lý tưởng hóa hoặc quá hy sinh, điều này có thể dẫn đến việc bỏ qua nhu cầu của bản thân. Việc thiết lập ranh giới lành mạnh và giao tiếp cởi mở sẽ giúp bạn duy trì mối quan hệ hài hòa và bền vững.',
                'challenges' => [
                    'Quá hy sinh: Dễ dẫn đến việc bỏ qua nhu cầu và cảm xúc của bản thân.',
                    'Lý tưởng hóa quá mức: Có thể gây ra thất vọng khi thực tế không như mong đợi.',
                    'Khó buông bỏ quá khứ: Dễ bị mắc kẹt trong những kỷ niệm hoặc tổn thương cũ.'
                ],
                'advice' => [
                    'Chăm sóc bản thân: Dành thời gian để nghỉ ngơi, thư giãn và nạp lại năng lượng.',
                    'Thiết lập ranh giới: Học cách nói "không" khi cần thiết để bảo vệ bản thân.',
                    'Thực hành chánh niệm: Giúp bạn sống trong hiện tại và buông bỏ những điều không còn phục vụ bạn.'
                ]
            ],
            11 => [
                'title' => 'Số Tính Cách 11',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Bạn mang Số Tính Cách là 11 – một con số chủ đạo thuộc nhóm Master Number hiếm và đầy sức hút. Trong mắt người khác, bạn có trường khí đặc biệt, toát ra vẻ huyền bí, trí tuệ, tâm linh mà không cần nói quá nhiều. Bạn là người tĩnh nhưng có lực, thường thu hút người khác bằng ánh nhìn sâu lắng, phong thái nhẹ nhàng nhưng vững chãi, và cách nói chuyện như "chạm vào linh hồn". Mọi người có thể chưa hiểu hết bạn ngay lập tức, nhưng thường cảm thấy an yên, được truyền cảm hứng hoặc có gì đó "tâm linh" khi tiếp xúc với bạn.',
                'career' => 'Bạn thường được đánh giá là có tầm nhìn, nhạy bén với ý tưởng mới hoặc chiều sâu chiến lược. Dù không phải người thích cạnh tranh ồn ào, bạn có khả năng ảnh hưởng người khác bằng sự thuyết phục nhẹ nhàng và trực giác tinh tế. Người khác dễ tìm đến bạn như một người cố vấn, lắng nghe và chỉ đường. Bạn thích những môi trường cho phép sự sáng tạo, suy tưởng, tính tâm linh hoặc nhân đạo – tránh xa môi trường thực dụng, khô khan.',
                'relationships' => 'Bạn tạo cảm giác đáng tin và sâu sắc trong tình yêu. Người yêu của bạn thường cảm nhận bạn như "người thấu hiểu tôi nhất mà tôi từng gặp". Tuy nhiên: Bạn có thể khó mở lòng hoàn toàn ban đầu, vì cần cảm giác an toàn năng lượng. Bạn cũng có xu hướng lý tưởng hóa tình yêu, điều này dễ dẫn đến thất vọng nếu đối phương không đủ tinh tế.',
                'challenges' => [
                    'Dễ bị hiểu nhầm là lạnh lùng, xa cách, trong khi bạn chỉ đang giữ năng lượng riêng.',
                    'Quá nhạy với năng lượng tiêu cực, khiến bạn mệt mỏi nếu ở chốn ồn ào, lộn xộn.',
                    'Có thể tự tạo áp lực cho bản thân, vì cảm thấy mình "phải có vai trò đặc biệt" trong cuộc đời.'
                ],
                'advice' => [
                    'Giữ ranh giới năng lượng rõ ràng, tránh bị cuốn theo cảm xúc của người khác.',
                    'Cho phép bản thân hiện diện mà không cần phải "đúng" hoặc "hoàn hảo".',
                    'Khi bạn sống đúng với sự tĩnh tại và trực giác, bạn sẽ lan tỏa ánh sáng tinh tế và cảm hóa người khác bằng chính sự hiện diện của mình.'
                ]
            ],
            22 => [
                'title' => 'Số Tính Cách 22',
                'calculation' => 'Tính từ tổng giá trị các phụ âm trong họ tên',
                'characteristics' => 'Người mang Số Tính Cách 22 thường được người khác cảm nhận là điềm tĩnh, trưởng thành hơn tuổi, có khí chất ổn định và đáng nể. Bạn không cần phô trương nhưng vẫn tạo nên sự tin cậy, vững chắc ngay từ lần đầu gặp mặt. Không giống như những người thích thể hiện cá tính, bạn để lại ấn tượng bằng sự chững chạc, trầm ổn, đôi khi có phần quá nghiêm túc trong mắt người khác. Tuy nhiên, với ai đủ tinh tế, họ sẽ cảm nhận được bên trong bạn là sức mạnh tổ chức âm thầm, tư duy hệ thống và phẩm chất lãnh đạo tiềm ẩn.',
                'career' => 'Bạn phù hợp với những vai trò yêu cầu khả năng tổ chức, quản lý dự án lớn và xây dựng hệ thống bền vững. Các lĩnh vực như kiến trúc, xây dựng, quản lý doanh nghiệp, hoặc các dự án cộng đồng quy mô lớn là nơi bạn có thể phát huy tối đa khả năng của mình. Bạn có khả năng biến tầm nhìn thành hiện thực thông qua kế hoạch chi tiết và thực thi kiên định. Người khác tin tưởng giao phó những dự án quan trọng cho bạn vì biết bạn sẽ hoàn thành một cách xuất sắc.',
                'relationships' => 'Người khác cảm thấy an toàn khi ở cạnh bạn, dù không biết rõ lý do vì sao. Bạn ít khi chia sẻ về cảm xúc cá nhân, điều này đôi khi khiến người khác thấy bạn "cứng" hoặc "khó hiểu". Tuy nhiên, bạn lại là người luôn hiện diện khi cần, và giữ cam kết một cách bền bỉ – điều này khiến bạn có giá trị đặc biệt trong tình bạn, tình yêu, và công việc.',
                'challenges' => [
                    'Cứng nhắc trong hình ảnh: Có thể bị hiểu nhầm là "quá nguyên tắc" hoặc "thiếu linh hoạt".',
                    'Khó thể hiện cảm xúc mềm: Điều này có thể tạo khoảng cách với người mới tiếp xúc.',
                    'Áp lực giữ vai trò mẫu mực: Dễ tự "đóng khung" bản thân thành người phải luôn gương mẫu.'
                ],
                'advice' => [
                    'Học cách thể hiện cảm xúc một cách tự nhiên hơn để tạo kết nối sâu sắc với người khác.',
                    'Cho phép bản thân được phép sai và không hoàn hảo đôi khi.',
                    'Cân bằng giữa trách nhiệm và niềm vui trong cuộc sống.'
                ]
            ]
        ];
    }

    /**
     * Get attitude number interpretations data from source code
     */
    public static function getAttitudeNumberInterpretationsData()
    {
        return [
            1 => [
                'title' => 'Số Thái Độ 1 – Người Tự Tin & Quyết Đoán',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ phản ánh ấn tượng ban đầu bạn tạo ra khi xuất hiện với người khác – phong thái, phản ứng đầu tiên và cách bạn "ra đời" trong mắt thế giới. Vậy nếu bạn có Số Thái Độ là 1, điều này cho thấy:',
                'firstImpression' => 'Bạn thường xuất hiện với sự tự tin, độc lập và quyết đoán. Người khác nhìn bạn như người "dẫn đầu", mạnh mẽ và tự chủ – ngay cả khi bạn chưa nói gì, nét mặt và cử chỉ toát lên năng lượng lãnh đạo.',
                'naturalReaction' => 'Bạn là người tự động triển khai hành động, ít khi chờ đợi hướng dẫn. Bạn thường nghĩ: "Mình làm được" và bắt tay vào việc ngay, điều này giúp bạn tạo niềm tin và ảnh hưởng mạnh từ đầu.',
                'darkSide' => 'Tuy nhiên, phong thái này đôi khi khiến bạn bị nhìn nhận là cứng nhắc, độc đoán hoặc xa cách. Mọi người có thể thấy bạn "kiêu" hoặc không dễ gần – mặc dù bản chất của bạn chỉ là tập trung và quyết tâm.',
                'practicalApplication' => 'Trong giao tiếp và phỏng vấn: Hãy sử dụng tính cách chủ động này để tạo ấn tượng mạnh và tự tin, nhưng cân nhắc thêm chút nét linh hoạt, cảm thông để không quá áp đặt. Trong lãnh đạo & dự án: Bạn có tố chất mạnh mẽ, phù hợp vai trò điều hành, quản trị – chỉ cần nhớ "dẫn dắt chứ không áp đặt".'
            ],
            2 => [
                'title' => 'Số Thái Độ 2 – Dịu Dàng & Hòa Giải',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ phản ánh ấn tượng đầu tiên bạn tạo ra với người khác – cách bạn xuất hiện, phản ứng khi gặp tình huống mới, và năng lượng bạn phát ra ngay từ lần tiếp xúc đầu tiên. Nếu bạn có Số Thái Độ là 2, điều đó cho thấy bạn thường mang đến cảm giác nhẹ nhàng, lịch thiệp và dễ gần ngay từ ánh nhìn đầu tiên.',
                'firstImpression' => 'Bạn là người nhạy cảm và giàu cảm xúc, luôn mang lại bầu không khí dễ chịu cho người xung quanh. Người khác cảm nhận bạn như một người lắng nghe chân thành, không vội vã, biết quan sát và có thiện chí kết nối. Nét duyên ngầm và thái độ nhẹ nhàng giúp bạn thu hút những người cần sự an ủi, đồng hành – bạn không cần nói nhiều, chỉ cần hiện diện cũng khiến người khác thấy thoải mái.',
                'naturalReaction' => 'Bạn có xu hướng tiếp cận một cách nhẹ nhàng, cẩn trọng và uyển chuyển, thay vì hành động vội vàng. Trong môi trường mới, bạn thường giữ thế quan sát, chờ đợi thời điểm phù hợp để hòa nhập – chứ không "lao vào" ngay lập tức. Sự tinh tế này giúp bạn xử lý tình huống bằng cảm xúc thông minh, chứ không chỉ bằng lý trí.',
                'darkSide' => 'Dễ bị xem là quá dè dặt hoặc thiếu chủ động. Có thể gặp khó khăn khi phải nói "không" hoặc thể hiện chính kiến. Nếu quá nhạy cảm, bạn dễ bị ảnh hưởng bởi cảm xúc tiêu cực của người khác.',
                'practicalApplication' => 'Trong giao tiếp: bạn là người tạo "cầu nối" tuyệt vời, hãy tin vào trực giác của mình – nhưng cũng cần rèn kỹ năng nói rõ nhu cầu cá nhân. Trong công việc nhóm: bạn hợp với vai trò điều phối, làm cầu nối, hoặc những lĩnh vực cần sự tinh tế, nghệ thuật, chăm sóc. Trong phát triển cá nhân: hãy học cách chủ động thể hiện ý kiến một cách mềm mỏng nhưng dứt khoát – sự nhẹ nhàng là thế mạnh, không phải điểm yếu.'
            ],
            3 => [
                'title' => 'Số Thái Độ 3 – Tỏa Sáng & Giao Tiếp',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ thể hiện ấn tượng đầu tiên bạn để lại, phong cách bạn thể hiện khi gặp người mới hoặc bước vào hoàn cảnh lạ. Khi bạn có Số Thái Độ là 3, bạn mang đến một năng lượng đầy niềm vui, sáng tạo và sự lôi cuốn ngay từ lần tiếp xúc đầu tiên.',
                'firstImpression' => 'Bạn thường được người khác nhớ đến như một người vui tính, linh hoạt và dễ gần, với nụ cười trên môi và câu chuyện lôi cuốn. Bạn lan toả cảm giác tươi mới, truyền cảm hứng, khiến mọi người dễ bị thu hút và muốn trò chuyện cùng bạn. Sự hoạt ngôn, dí dỏm và đầy sinh khí tạo nên một "làn gió mới" mỗi khi bạn xuất hiện.',
                'naturalReaction' => 'Bạn có xu hướng chủ động giao tiếp, kể chuyện, tạo tiếng cười và tạo ra một không khí thân thiện nơi bạn đến. Những câu nói hài hước hoặc cách kể chuyện độc đáo giúp bạn nhanh chóng "phá băng" không khí đầu tiên.',
                'darkSide' => 'Năng lượng rực rỡ dễ khiến bạn bị đánh giá là thiếu nghiêm túc, không sâu sắc; có khi dàn trải hoặc không giữ được sự tập trung, bởi bạn quá thích lan toả năng lượng từ đầu. Tránh trường hợp "phát sáng lung linh mà không đi đến đích".',
                'practicalApplication' => 'Trong giao tiếp: bạn có lợi thế tự nhiên là người "sôi nổi dẫn dắt cuộc trò chuyện" – tận dụng để xây dựng kết nối nhanh nhưng đừng quên thêm chiều sâu. Trong thuyết trình, tổ chức sự kiện, marketing: đây là vai trò đánh thức mọi người, tạo khí thế và động lực. Phát triển cá nhân: hãy học cách tạo độ nghiêm túc vừa đủ, chuyển năng lượng bùng nổ thành sự tập trung có mục đích – để "hòa sắc" thành bài hát có nội dung chứ không chỉ nhạc nền.'
            ],
            4 => [
                'title' => 'Số Thái Độ 4 – Người Xây Dựng & Đáng Tin Cậy',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ thể hiện ấn tượng đầu tiên bạn tạo ra, phản ánh phong thái bạn mang đến cho môi trường mới. Nếu bạn có Số Thái Độ là 4, bạn xuất hiện như một người ổn định, có tổ chức và đáng tin cậy ngay từ lần đầu tiên gặp gỡ.',
                'firstImpression' => 'Bạn tạo cảm giác như "cột trụ vững chắc" mỗi khi xuất hiện – logic, rõ ràng và có kế hoạch. Người khác nhìn bạn như một người có tinh thần làm việc nghiêm túc, luôn điềm tĩnh, có tổ chức và giữ lời hứa. Phong thái của bạn toát lên sự chăm chỉ và trách nhiệm – ai cần sự vững vàng, đều tìm đến bạn ngay lập tức.',
                'naturalReaction' => 'Khi đối diện với điều không biết, bạn thường quan sát, phân tích rồi hành động có hệ thống, thay vì bốc đồng. Bạn thích tìm hiểu logic, đặt câu hỏi, và lên kế hoạch tỉ mỉ – giúp bạn dễ dàng xử lý tình huống một cách thực tế và hiệu quả ngay từ đầu.',
                'darkSide' => 'Đôi khi bạn có thể bị xem là cứng nhắc hoặc thiếu linh hoạt, nhất là khi người khác cần thay đổi nhanh chóng. Bạn dễ rơi vào tâm thế "ăn chắc mặc bền" dẫn đến bỏ lỡ cơ hội sáng tạo hoặc thử thách mới.',
                'practicalApplication' => 'Phong cách chuyên nghiệp: Rất phù hợp với vai trò quản lý, tổ chức, lập kế hoạch – nơi cần một cá nhân đáng tin cậy để giữ trật tự và thực hiện theo đúng cam kết. Trong giao tiếp xã hội: Dùng sự chắc chắn của bạn để tạo niềm tin ngay từ đầu, nhưng hãy linh hoạt để tạo chiều sâu và sự gần gũi. Phát triển cá nhân: Học cách thả lỏng tâm thế, đón nhận những thay đổi bất ngờ để nâng cao sự linh hoạt – điều này sẽ làm phong phú thêm con đường bạn đang đi.'
            ],
            5 => [
                'title' => 'Số Thái Độ 5 – Linh Hoạt & Phiêu Lưu',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ phản ánh ấn tượng đầu tiên bạn tạo ra khi xuất hiện trong môi trường mới hoặc gặp người mới – cách bạn "ra mặt" với thế giới. Nếu bạn có Số Thái Độ là 5, điều đó cho thấy bạn mang đến năng lượng của sự tự do, linh hoạt và tinh thần khám phá ngay từ lần đầu tiên tiếp xúc.',
                'firstImpression' => 'Bạn thường bị nhầm là người tự do, nhanh nhạy, dễ chinh phục. Con người bạn hiện ra như một người tràn đầy năng lượng, thích vui vẻ và không chịu đứng yên, luôn sẵn sàng thử cái mới và bất ngờ. Sự hiện diện của bạn như một làn gió mới, nhanh chóng tạo cảm giác thích thú và tò mò nơi người tiếp xúc đầu tiên.',
                'naturalReaction' => 'Bạn phản ứng bằng sự linh hoạt và thích ứng mạnh mẽ – thay vì xem thử thì bạn lao vào trải nghiệm và khám phá. Mọi tình huống mới, bạn tiếp cận với tâm thế tò mò, mở lòng và không sợ thay đổi. Chính vì vậy, bạn dễ khiến người khác cảm thấy "dễ chịu và hứng thú khi ở bên".',
                'darkSide' => 'Bạn có thể bị thấy là thiếu chung thủy, khó xây dựng cam kết dài, vì luôn thôi thúc bản thân "đi tìm cái mới". Tinh thần tự do dễ trở thành bốc đồng, mất kiểm soát, hoặc thiếu kỷ luật khi gặp thử thách thực sự.',
                'practicalApplication' => 'Trong giao tiếp & môi trường mới: bạn tạo cảm giác nhẹ nhàng, bớt căng thẳng và dễ gây thiện cảm – đó là lợi thế rất lớn. Trong công việc & học tập: phù hợp với dự án yêu cầu sáng tạo, nhanh thay đổi, động lực khám phá – nhưng cần rèn kỹ năng hoàn tất nhiệm vụ và đúng hạn. Phát triển cá nhân: hãy học cách đặt mục tiêu rõ ràng, duy trì cam kết, giữ cho năng lượng tự do không chìm vào hoang mang hay thiếu kiểm soát.'
            ],
            6 => [
                'title' => 'Số Thái Độ 6 – Người Chăm Sóc & Hài Hòa',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ thể hiện ấn tượng đầu tiên bạn tạo ra – cách bạn tự giới thiệu bản thân và phản ứng với thế giới khi người khác lần đầu gặp bạn. Nếu bạn có Số Thái Độ là 6, bạn tỏa ra năng lượng của một cá nhân chăm sóc, đáng tin và đề cao sự hòa hợp, tạo cảm giác an toàn ngay trong giao tiếp ban đầu.',
                'firstImpression' => 'Bạn là người chăm sóc, có trách nhiệm và hòa ái, khiến người khác cảm thấy được trân trọng và an tâm khi ở bên. Bạn mang đến cảm giác "ai cần giúp đỡ cứ đến mình" – một lực lượng ấm áp, gắn kết ngay từ lần đầu gặp. Bạn có khả năng tổ chức không gian thân thiện, sắp xếp ổn thỏa – như một người "làm tròn vai khi cần hòa hợp nhóm".',
                'naturalReaction' => 'Bạn phản ứng bằng sự ân cần, trợ giúp, luôn sẵn sàng dọn dẹp, hỗ trợ, hoặc đứng ra gánh vác cho môi trường mới của mình – từ phòng làm việc đến nhóm bạn thân. Khi gặp người mới, bạn thường bước vào với vai trò "chìa khóa ổn định", phản ứng thận trọng nhưng đầy sự quan tâm.',
                'darkSide' => 'Bạn có thể bị người khác xem là quá bảo vệ, thích kiểm soát hoặc hơi gia trưởng – đặc biệt khi bạn đứng vào vị trí "người phải lo hết mọi thứ". Sự tập trung quá mức vào trật tự có thể khiến bạn khó chịu với sự bất ổn, và đôi khi thiếu không gian cho chính mình.',
                'practicalApplication' => 'Giao tiếp xã hội: bạn là người phù hợp để giúp đỡ, hướng dẫn hoặc hỗ trợ người mới – chỉ cần nhớ "giúp đúng lúc, không bao vây quá sát". Trong công việc & dự án: vai trò bạn rất phù hợp là quản lý, hỗ trợ, hoặc tổ chức đội – nơi cần người "chăm lo cho sự an toàn và ổn định". Phát triển cá nhân: cần học cách trao quyền cho người khác, và để cho "quá khứ rơi vào tay người mới" – để giảm áp lực tự gánh vác.'
            ],
            7 => [
                'title' => 'Số Thái Độ 7 – Người Trầm Lặng & Tinh Tế',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ phản ánh ấn tượng đầu tiên bạn tạo ra khi xuất hiện với người khác – cách bạn "phát sóng" năng lượng và phong cách khi mới gặp hoặc bước vào môi trường mới. Nếu bạn có Số Thái Độ là 7, bạn mang đến ấn tượng về một cá nhân sâu sắc, quan sát tinh tế và ít nói, khiến người khác cảm thấy bạn có chiều sâu nội tâm đáng để khám phá.',
                'firstImpression' => 'Bạn thường được nhìn nhận là người bí ẩn, điềm tĩnh và thông thái. Mọi người cảm thấy bạn đang lắng nghe sâu sắc, suy nghĩ chín chắn trước khi nói - và điều đó tạo ra sự tin cậy. Bạn không cần phải nói nhiều để gây ấn tượng; đôi khi chỉ cần im lặng quan sát cũng đủ để người khác cảm nhận thấy độ sâu trong bạn.',
                'naturalReaction' => 'Khi đối diện với điều mới mẻ, bạn không lao vào khám phá ngay, mà lựa chọn cách quan sát trước – phân tích – sau đó mới phản ứng. Cảm xúc và hành động đều đến sau khi trí tuệ nội tâm đã có đủ dữ kiện. Bạn dễ được nhớ đến như người "đứng ngoài dòng chảy", với cái nhìn sâu sắc và logic hơn người bình thường.',
                'darkSide' => 'Bạn có thể bị cho là xa cách, kiệm lời đến mức lạnh lùng, trong khi thực ra bạn chỉ đang "tham vấn tâm trí" trước khi bung ra. Sự tĩnh lặng và phân tích quá mức có thể khiến bạn khó bộc lộ cảm xúc hoặc kết nối nhanh với người khác – đặc biệt trong môi trường cần giao tiếp năng động.',
                'practicalApplication' => 'Trong giao tiếp: bạn phù hợp để là người tư vấn, phân tích tình huống, hoặc đưa ra góc nhìn sâu sắc. Chỉ cần "mở lời lúc thích hợp" sẽ khiến bạn trở nên quý giá. Trong công việc & học thuật: vai trò nghiên cứu, phân tích, chiến lược cực kỳ hợp với bạn. Phát triển cá nhân: học cách thả lỏng sự quan sát, tập giao tiếp trực tiếp hơn để tạo dựng mối liên kết sâu đậm khi cần thiết.'
            ],
            8 => [
                'title' => 'Số Thái Độ 8 – Người Quyền Lực và Có Thẩm Quyền',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ phản ánh ấn tượng đầu tiên bạn để lại khi mới gặp gỡ hoặc bước vào môi trường mới. Nếu bạn có Thái Độ là 8, bạn tự nhiên tạo ra hình ảnh của một người đứng đầu, mạnh mẽ, quyết đoán và có năng lực điều hành. Người khác dễ nhận thấy ở bạn sự tự tin, khả năng tổ chức, và một nguồn năng lượng định hướng tới thành công.',
                'firstImpression' => 'Ngay từ lần gặp đầu tiên, bạn tạo cảm giác mình là người có mục tiêu rõ ràng, biết mình muốn gì và không ngại theo đuổi điều đó. Bạn thường được xem là người có trách nhiệm, có sức ảnh hưởng và có tố chất lãnh đạo tự nhiên. Dù bạn không cố thể hiện, người khác vẫn cảm thấy bạn có khả năng điều phối và dẫn dắt.',
                'naturalReaction' => 'Bạn phản ứng nhanh chóng và hiệu quả. Khi tiếp xúc với môi trường mới, bạn thường chú ý đến cấu trúc, sự hợp lý, hiệu suất và giá trị thực tế. Bạn có xu hướng nhìn mọi việc qua lăng kính của hiệu quả, quyền hạn và khả năng kiểm soát. Điều này khiến bạn dễ được tin tưởng giao nhiệm vụ hoặc vai trò trọng yếu.',
                'darkSide' => 'Vì mang phong cách mạnh mẽ, bạn có thể bị người khác cảm nhận là xa cách, kiểm soát quá mức hoặc quá tập trung vào thành tích mà thiếu đi sự mềm mại cần thiết trong giao tiếp. Một số người có thể thấy bạn nghiêm khắc, hoặc không dễ mở lòng dù bạn chỉ đang giữ sự chuyên nghiệp và rõ ràng.',
                'practicalApplication' => 'Trong môi trường chuyên nghiệp, bạn phù hợp với các vai trò lãnh đạo, điều hành hoặc giám sát dự án. Trong giao tiếp, hãy kết hợp sự cứng cáp của bạn với sự lắng nghe và thấu hiểu để tạo ảnh hưởng bền vững hơn. Về phát triển cá nhân, bạn nên học cách trao quyền, tin tưởng người khác và đôi khi buông lỏng một chút để mọi việc diễn ra linh hoạt hơn.'
            ],
            9 => [
                'title' => 'Số Thái Độ 9 – Người Nhân Ái và Truyền Cảm Hứng',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ phản ánh ấn tượng đầu tiên bạn để lại cho người khác – cách bạn xuất hiện, phản ứng với môi trường mới, và năng lượng bạn lan tỏa khi tiếp xúc lần đầu. Nếu bạn có Thái Độ là 9, bạn thường được nhìn nhận là một người sâu sắc, bao dung, và mang trong mình lý tưởng sống cao đẹp. Phong thái của bạn khiến người khác cảm thấy an toàn, được thấu hiểu và dễ chia sẻ.',
                'firstImpression' => 'Bạn mang lại cảm giác của một người đã trải qua nhiều điều, trưởng thành hơn tuổi, và có khả năng nhìn mọi việc từ góc độ nhân văn. Người khác thường thấy bạn nhẹ nhàng, thấu cảm, và sẵn sàng hỗ trợ người khác mà không đòi hỏi. Nét cuốn hút của bạn đến từ sự chân thành và tinh thần cho đi hơn là phô trương bản thân.',
                'naturalReaction' => 'Khi đối diện với điều mới, bạn thường tiếp cận bằng sự quan sát đầy cảm xúc. Bạn muốn hiểu sâu lý do phía sau, chứ không chỉ nắm bề mặt sự việc. Bạn có xu hướng suy nghĩ rộng, nhìn vào bức tranh toàn cảnh và phản ứng dựa trên giá trị đạo đức hoặc lý tưởng cá nhân. Điều này khiến bạn dễ được người khác tin tưởng và tìm đến khi cần lời khuyên.',
                'darkSide' => 'Vì thường sống lý tưởng và hay quan tâm đến người khác, bạn đôi khi có thể trở nên quá nhạy cảm, dễ tổn thương nếu bị hiểu lầm. Ngoài ra, bạn cũng có xu hướng ôm đồm hoặc cố gắng cứu giúp quá nhiều người, dẫn đến kiệt sức hoặc lạc lối. Một số người có thể thấy bạn hơi xa vời, hoặc khó nắm bắt vì bạn thường không thể hiện hết nội tâm của mình.',
                'practicalApplication' => 'Trong giao tiếp, bạn là người truyền cảm hứng và dễ tạo lòng tin, đặc biệt với những ai đang gặp khó khăn hoặc tìm kiếm sự đồng hành về tinh thần. Trong công việc, bạn phù hợp với vai trò tư vấn, giáo dục, nghệ thuật hoặc các lĩnh vực mang giá trị nhân đạo. Về phát triển cá nhân, hãy học cách đặt ranh giới, chọn lọc người cần giúp và nuôi dưỡng bản thân bằng cách chăm sóc chính mình trước tiên.'
            ],
            11 => [
                'title' => 'Số Thái Độ 11 – Người Khai Sáng & Trực Giác',
                'calculation' => 'Tính từ ngày và tháng sinh',
                'prominentCharacteristics' => 'Số Thái Độ lý giải ấn tượng đầu tiên bạn để lại, phong thái bạn phát ra khi xuất hiện hoặc ở trong bối cảnh mới. Nếu bạn có Thái Độ là 11, điều này cho thấy bạn tự nhiên tỏa ra năng lượng của một nhà khai sáng tâm linh, trực giác sắc bén và có tầm ảnh hưởng mạnh mẽ.',
                'firstImpression' => 'Bạn tạo cảm giác như một người có trí tuệ vượt trội, nhạy bén và giàu cảm xúc, khiến người khác cảm nhận bạn là người sâu sắc, có chiều sâu và dường như đang "nghe thấy những gì người khác không nói". Năng lượng bạn mang đến thường được ví như ánh sáng dẫn đường – thu hút một cách đầy bí ẩn và tinh tế.',
                'naturalReaction' => 'Bạn phản ứng bằng cách kết nối trí tuệ với cảm xúc, thường có cảm hứng sáng tạo sâu sắc và trực giác sắc bén. Khi gặp khó khăn, bạn không chỉ phân tích mà còn dùng cảm nhận nội tâm để phán đoán – đó là lý do bạn dễ tin cậy trong vai trò tư vấn, tâm linh, hoặc truyền cảm hứng.',
                'darkSide' => 'Năng lượng cao có thể dẫn bạn đến trạng thái quá nhạy cảm, dễ lo âu hoặc mất cân bằng, nhất là khi bạn không kiểm soát cảm xúc mạnh. Bạn có thể cảm thấy bị cô lập hoặc bị hiểu lầm, vì người khác khó theo kịp chiều sâu suy nghĩ và cảm xúc mà bạn đang truyền tải.',
                'practicalApplication' => 'Trong giao tiếp: bạn phù hợp vai trò như người truyền cảm hứng, hướng dẫn, tạo động lực và định hướng tinh thần sâu sắc. Trong công việc: thích hợp với vai trò lãnh đạo đổi mới, tư vấn, nghệ thuật, hoặc các ngành nghề đòi hỏi trực giác cao – nơi bạn có thể làm cầu nối giữa ý tưởng và thực tế. Phát triển cá nhân: hãy học cách kiềm chế cảm xúc, giữ sự tỉnh táo trong nhạy cảm, và nuôi dưỡng cấu trúc để biến trực giác thành hành động hiệu quả.'
            ]
        ];
    }

    public static function getMaturityNumberInterpretationsData()
    {
        return [
            1 => [
                'title' => 'Số Trưởng Thành 1 – Khai mở con đường tự chủ và lãnh đạo từ bên trong',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Khi bước vào giai đoạn trưởng thành, đặc biệt từ khoảng tuổi 35 trở đi, bạn sẽ bắt đầu cảm nhận rõ ràng hơn về sự thôi thúc phải đứng lên làm chủ cuộc đời mình. Số Trưởng Thành 1 cho thấy rằng hành trình phát triển của bạn đang hướng tới sự độc lập, bản lĩnh và khả năng lãnh đạo cá nhân.',
                'sections' => [
                    [
                        'title' => '🌟 Đặc điểm chính',
                        'content' => 'Đây là giai đoạn bạn không còn mong đợi người khác dẫn lối. Ngược lại, bạn trở nên quyết đoán, tự tin và dám nghĩ dám làm. Những trải nghiệm trước đây đã hun đúc cho bạn lòng can đảm để khởi xướng những việc mới, đưa ra quyết định rõ ràng và chịu trách nhiệm cho chính con đường mình chọn.'
                    ],
                    [
                        'title' => '🎯 Tài năng thiên bẩm',
                        'content' => 'Tài năng thiên bẩm của bạn nằm ở việc trở thành người tiên phong, người dẫn đầu không cần ồn ào, nhưng có chính kiến mạnh mẽ và dám hành động. Bạn không chỉ muốn thành công cho riêng mình, mà còn truyền cảm hứng để người khác cũng dám sống theo cách họ thật sự mong muốn.'
                    ],
                    [
                        'title' => '💫 Thông điệp trưởng thành',
                        'content' => 'Số Trưởng Thành 1 là dấu hiệu cho thấy: bạn càng trưởng thành, càng trở nên vững vàng, mạnh mẽ và có khả năng tự định hướng số phận. Nếu bạn tin vào tiếng nói bên trong và hành động kiên định, con đường thành tựu sẽ ngày càng rộng mở.'
                    ]
                ]
            ],
            2 => [
                'title' => 'Số Trưởng Thành 2 – Vươn tới sự hài hòa, hợp tác và sức mạnh tinh tế',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Từ khoảng sau 35 tuổi trở đi, bạn sẽ dần thể hiện rõ tố chất đặc biệt của mình – đó là tài năng xây dựng sự đồng điệu trong mọi mối quan hệ. Số Trưởng Thành 2 mang đến cho bạn khả năng giao tiếp tinh tế, điều phối quan hệ khéo léo, và tạo ra không gian chung đầy tin cậy, hỗ trợ.',
                'sections' => [
                    [
                        'title' => '🌟 Tài năng đặc biệt',
                        'content' => 'Bạn trở nên đặc biệt giỏi trong vai trò hòa giải, nhạy bén trong việc nhận thấy nhu cầu người khác và cân bằng các quan điểm đối lập. Điều này giúp bạn xây dựng mối quan hệ bền vững và tạo ảnh hưởng tích cực trong các nhóm, tổ chức hoặc gia đình.'
                    ],
                    [
                        'title' => '🤝 Phương thức lãnh đạo',
                        'content' => 'Số 2 trưởng thành không tìm cách "đứng lên dẫn đầu", mà nổi bật qua khả năng kết nối, làm cầu nối và mang lại hòa khí. Khi ở độ tuổi chín muồi, bạn dễ dàng phát triển kỹ năng "diplomacy" – khéo xử lý và đem lại sự hiểu nhau giữa mọi người.'
                    ],
                    [
                        'title' => '💝 Món quà cá nhân',
                        'content' => 'Dù trong công việc hay tình cảm, bạn đều biết cách lắng nghe, thấu cảm và giữ được sự tin cậy lâu dài. Đây chính là món quà cá nhân của bạn – giúp bạn thành công ở những vai trò yêu cầu sự cộng tác cao, xây dựng hoà bình và vun đắp mối quan hệ sâu sắc.'
                    ]
                ]
            ],
            3 => [
                'title' => 'Số Trưởng Thành 3 – Bừng sáng với sáng tạo, lạc quan và kết nối',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Từ khoảng tuổi 35–45 trở đi, bạn sẽ bắt đầu khám phá một phần bản thân mạnh mẽ nhất: năng lượng sáng tạo tràn đầy, khả năng thể hiện bản thân qua lời nói hoặc nghệ thuật, và khả năng lan tỏa niềm vui. Số trưởng thành 3 giúp bạn giải tỏa khối năng lượng tích tụ, kích hoạt tài năng để truyền cảm hứng cho người khác.',
                'sections' => [
                    [
                        'title' => '🎨 Khả năng sáng tạo',
                        'content' => 'Bạn sẽ dễ dàng khám phá nhiều cách khác nhau để thể hiện bản thân – có thể là viết lách, diễn thuyết, nghệ thuật, hay chỉ đơn giản là lan tỏa tiếng cười và niềm vui đến mọi người. Đây là giai đoạn bạn chứng minh sức mạnh của giao tiếp tích cực, truyền tải cảm hứng và xây dựng sự kết nối sâu sắc.'
                    ],
                    [
                        'title' => '🌈 Tự tin thể hiện',
                        'content' => 'Thời điểm này cũng giúp bạn tự tin hơn để chia sẻ chính mình, khám phá bản thân qua việc sáng tạo và lan tỏa năng lượng tích cực.'
                    ],
                    [
                        'title' => '⚖️ Cân bằng quan trọng',
                        'content' => 'Nếu biết cách kiểm soát để không bị "phân tán" (thiếu tập trung vào quá nhiều dự án), bạn sẽ đạt được sự hài hoà – vừa sống vui vẻ, vừa tạo dấu ấn cá nhân sâu sắc.'
                    ]
                ]
            ],
            4 => [
                'title' => 'Số Trưởng Thành 4 – Xây dựng nền tảng vững chắc và di sản bền vững',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Từ khoảng tuổi 35 trở đi, bạn sẽ ngày càng thể hiện rõ giá trị của năng lực xây dựng hệ thống và vận hành trơn tru cuộc sống. Số Trưởng Thành 4 giúp bạn phát huy mạnh mẽ phẩm chất thực tế, sự tỉ mỉ và lên kế hoạch có cấu trúc – những điều sẵn sàng chín muồi để hiện thực hóa mục tiêu lớn trong đời.',
                'sections' => [
                    [
                        'title' => '🏗️ Khả năng xây dựng',
                        'content' => 'Bạn là người có khả năng biến ý tưởng thành hiện thực, biết cách tổ chức, phân chia trách nhiệm và theo đuổi mục tiêu một cách kiên trì. Trong vai trò quản lý, lập dự án, sắp xếp tài chính hay bất cứ việc gì cần sự trật tự, bạn luôn là người được tin tưởng vì tính ổn định và đáng tin cậy của mình.'
                    ],
                    [
                        'title' => '💪 Sức chịu đựng',
                        'content' => 'Bên cạnh đó, bạn sở hữu sức chịu áp lực cao và khả năng hoàn thiện đến từng chi tiết – điều này rất phù hợp khi công việc hoặc dự án cần thời gian và độ chính xác dài hơi.'
                    ],
                    [
                        'title' => '🎯 Phẩm chất trưởng thành',
                        'content' => 'Đó không chỉ là năng lực, mà là phẩm chất trưởng thành tinh tế – bạn biết rằng thành công không chỉ đến từ đam mê mà còn từ lập trình cuộc sống bằng kỷ luật và tổ chức đúng đắn.'
                    ]
                ]
            ],
            5 => [
                'title' => 'Số Trưởng Thành 5 – Khám phá tự do, phiêu lưu và trải nghiệm đa chiều',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Từ khoảng tuổi 35 trở đi, bạn sẽ dần bộc lộ rõ nét năng lượng của sự thay đổi, khám phá và tự do cá nhân. Đây là giai đoạn bạn trở nên dũng cảm hơn trong việc bước ra khỏi vùng an toàn, sẵn sàng thử sức ở nhiều môi trường mới, lĩnh vực mới, và tiếp cận cuộc sống với một tâm thế cởi mở, linh hoạt.',
                'sections' => [
                    [
                        'title' => '🌍 Khả năng thích nghi',
                        'content' => 'Bạn có tài năng thiên bẩm trong việc thích nghi với hoàn cảnh, giao tiếp khéo léo và truyền cảm hứng cho người khác bằng tinh thần tươi mới, trẻ trung. Những cơ hội đến bất ngờ thường không làm bạn sợ hãi – ngược lại, bạn nhìn thấy ở đó tiềm năng phát triển, và dễ dàng "bắt sóng" đúng thời điểm để tiến bước.'
                    ],
                    [
                        'title' => '✨ Sức hút cá nhân',
                        'content' => 'Thời kỳ trưởng thành cũng là lúc bạn có xu hướng trở nên dễ cuốn hút, lôi cuốn người khác nhờ sự hoạt bát, thông minh và nhiệt huyết.'
                    ],
                    [
                        'title' => '🎯 Phát triển cần thiết',
                        'content' => 'Dù vậy, để thành công bền vững, bạn cần rèn luyện thêm sự tập trung và kiên định, tránh bị phân tán bởi quá nhiều ý tưởng hay thay đổi liên tục.'
                    ]
                ]
            ],
            6 => [
                'title' => 'Số Trưởng Thành 6 – Nuôi dưỡng tình yêu, trách nhiệm và sự hài hòa',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Bắt đầu từ khoảng tuổi 35, bạn sẽ ngày càng cảm nhận rõ hơn sứ mệnh của mình là chăm sóc, kết nối và tạo ra sự hài hòa trong các mối quan hệ. Số Trưởng Thành 6 mang đến cho bạn năng lượng của sự tận tâm, yêu thương và ý thức trách nhiệm cao – đặc biệt trong gia đình, công việc và cộng đồng.',
                'sections' => [
                    [
                        'title' => '💝 Vai trò chăm sóc',
                        'content' => 'Bạn dần trở thành người mà người khác tìm đến để xin lời khuyên, hỗ trợ hoặc đơn giản là tìm sự an yên. Khả năng thấu hiểu, bao dung và duy trì hòa khí giúp bạn tỏa sáng trong các vai trò như người hướng dẫn, cố vấn, giáo viên, cha mẹ, hoặc người xây dựng các tập thể vững mạnh.'
                    ],
                    [
                        'title' => '🏡 Khát khao xây dựng',
                        'content' => 'Thời kỳ trưởng thành cũng là lúc bạn thấy mình mong muốn tạo dựng môi trường sống đẹp hơn, cân bằng hơn – cả về vật chất lẫn cảm xúc.'
                    ],
                    [
                        'title' => '🌱 Phát triển năng lực',
                        'content' => 'Bạn dễ phát triển năng lực trong các lĩnh vực như giáo dục, chăm sóc sức khỏe, nghệ thuật thẩm mỹ, hoặc các hoạt động mang tính phục vụ xã hội.'
                    ]
                ]
            ],
            7 => [
                'title' => 'Số Trưởng Thành 7 – Khám phá chiều sâu tâm linh và trí tuệ nội tại',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Từ khoảng tuổi 35 trở đi, bạn sẽ bắt đầu cảm nhận rõ ràng hơn nhu cầu tìm kiếm chiều sâu, cả trong tri thức lẫn đời sống tinh thần. Số Trưởng Thành 7 mang đến cho bạn năng lượng của chiêm nghiệm, nghiên cứu và phát triển trí tuệ cá nhân.',
                'sections' => [
                    [
                        'title' => '🧠 Tìm kiếm chiều sâu',
                        'content' => 'Bạn không còn hứng thú với những thứ bề nổi hay ồn ào xung quanh – thay vào đó, bạn sẽ thấy mình bị thu hút bởi triết lý sống, tâm linh, khoa học, hoặc những lĩnh vực cần suy nghĩ độc lập và khám phá chiều sâu của thế giới.'
                    ],
                    [
                        'title' => '🏛️ Hành trình nội tâm',
                        'content' => 'Giai đoạn trưởng thành của bạn là hành trình quay về bên trong, để hiểu chính mình và vũ trụ một cách sâu sắc hơn.'
                    ],
                    [
                        'title' => '🎓 Trí tuệ sâu sắc',
                        'content' => 'Bạn có khả năng phân tích sắc bén, trực giác mạnh và cảm nhận tinh tế. Khi trưởng thành, bạn dễ trở thành người có tầm hiểu biết vượt trội, nói ít – hiểu nhiều, và thường được xem là người "thầy thầm lặng" trong mắt người khác.'
                    ]
                ]
            ],
            8 => [
                'title' => 'Số Trưởng Thành 8 – Nắm giữ quyền lực vật chất và thành tựu lớn',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Kể từ khoảng tuổi 35 trở đi, bạn sẽ bắt đầu phát huy mạnh mẽ năng lượng của thành công vật chất, tư duy chiến lược và năng lực lãnh đạo. Số Trưởng Thành 8 là dấu hiệu cho thấy bạn đang bước vào thời kỳ có thể vươn tới những vị trí cao, đạt được ảnh hưởng xã hội và kiểm soát tốt tài chính cá nhân.',
                'sections' => [
                    [
                        'title' => '💼 Năng lực lãnh đạo',
                        'content' => 'Bạn sở hữu bản năng điều hành, khả năng ra quyết định nhanh và đầu óc kinh doanh sắc bén. Khi trưởng thành, bạn sẽ nhận ra rằng mình có thể xây dựng tài sản, vận hành hệ thống hoặc tổ chức, miễn là bạn kiên trì, kỷ luật và biết sử dụng sức mạnh đúng cách.'
                    ],
                    [
                        'title' => '⚖️ Thách thức đạo đức',
                        'content' => 'Tuy nhiên, đi kèm với năng lượng mạnh mẽ là thử thách về đạo đức và trách nhiệm.'
                    ],
                    [
                        'title' => '🏆 Thành công thật sự',
                        'content' => 'Bạn có thể trở thành hình mẫu của sự thành công và ảnh hưởng – nếu bạn kết hợp tham vọng với sự chính trực và lòng bao dung.'
                    ]
                ]
            ],
            9 => [
                'title' => 'Số Trưởng Thành 9 – Sống vì nhân loại và di sản tinh thần',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Từ khoảng tuổi 35 trở đi, bạn sẽ cảm thấy ngày càng rõ rệt mong muốn làm điều gì đó có ý nghĩa vượt lên trên lợi ích cá nhân. Số Trưởng Thành 9 dẫn bạn đến giai đoạn trưởng thành đầy cảm hứng, nơi lòng nhân ái, sự cho đi và sứ mệnh phục vụ cộng đồng trở thành trung tâm cuộc sống.',
                'sections' => [
                    [
                        'title' => '🌍 Tầm nhìn toàn cầu',
                        'content' => 'Bạn có cái nhìn bao quát, dễ cảm nhận được nỗi đau của người khác và thường tìm cách giúp đỡ mà không cần được ghi nhận. Năng lượng của bạn phù hợp với những hoạt động mang tính chữa lành, sáng tạo, giáo dục, nhân đạo, hoặc nghệ thuật truyền cảm.'
                    ],
                    [
                        'title' => '💖 Sống vị tha',
                        'content' => 'Khi sống đúng với năng lượng này, bạn sẽ trở thành người truyền cảm hứng, dẫn dắt bằng lòng vị tha, và gieo mầm yêu thương trong mọi việc mình làm.'
                    ],
                    [
                        'title' => '🌟 Thành công đích thực',
                        'content' => 'Thành công đến với bạn không nằm ở sự tích lũy vật chất, mà ở ảnh hưởng tích cực bạn để lại trong lòng người khác.'
                    ]
                ]
            ],
            11 => [
                'title' => 'Số Trưởng Thành 11 – Trực giác siêu phàm và sứ mệnh truyền cảm hứng',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Kể từ khoảng tuổi 35 trở đi, bạn sẽ bắt đầu cảm nhận sâu sắc hơn về sứ mệnh tinh thần của mình. Số Trưởng Thành 11 là con số "bậc thầy" (Master Number), biểu hiện cho một hành trình trưởng thành phi thường, nơi bạn được mời gọi trở thành người truyền cảm hứng, kết nối tâm linh và soi đường cho người khác.',
                'sections' => [
                    [
                        'title' => '🔮 Khả năng siêu phàm',
                        'content' => 'Bạn có khả năng trực giác mạnh mẽ, cảm nhận được điều chưa được nói ra, và thường có những hiểu biết sâu sắc về cuộc sống, nhân sinh, tâm lý con người. Khi bạn phát triển đến giai đoạn chín muồi, những nhận thức này sẽ không còn là điều mơ hồ – mà trở thành tài sản tinh thần quý giá để hỗ trợ cộng đồng và chữa lành thế giới xung quanh.'
                    ],
                    [
                        'title' => '⚖️ Thách thức lớn',
                        'content' => 'Tuy nhiên, đi kèm với tiềm năng lớn là áp lực lớn. Bạn có thể trải qua những biến động nội tâm, sự nhạy cảm quá mức, hoặc nghi ngờ chính mình.'
                    ],
                    [
                        'title' => '🌉 Cân bằng quan trọng',
                        'content' => 'Điều quan trọng là học cách kết nối giữa tinh thần và thực tế, sống cân bằng để phát huy hết sức mạnh của mình.'
                    ]
                ]
            ],
            22 => [
                'title' => 'Số Trưởng Thành 22 – Master Builder với tầm nhìn vĩ đại',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Từ khoảng tuổi 35 trở đi, bạn bắt đầu bước vào giai đoạn trưởng thành với tiềm năng xây dựng những điều có ảnh hưởng lâu dài cho xã hội. Số 22 là một trong những con số "bậc thầy" (Master Number), mang năng lượng hiếm có: sự kết hợp giữa tầm nhìn tinh thần của số 11 và sự thực tế vững vàng của số 4.',
                'sections' => [
                    [
                        'title' => '🏗️ Năng lực kiến tạo',
                        'content' => 'Bạn được sinh ra để kiến tạo – không phải những điều nhỏ nhặt, mà là những dự án, công trình hoặc hành động có sức ảnh hưởng sâu rộng, quy mô lớn, và có khả năng tồn tại qua thời gian. Bạn là người biết biến giấc mơ thành kế hoạch, và kế hoạch thành hiện thực.'
                    ],
                    [
                        'title' => '🎯 Sức mạnh trưởng thành',
                        'content' => 'Sức mạnh trưởng thành của bạn nằm ở việc vừa có tầm nhìn xa, vừa có khả năng tổ chức, lãnh đạo, kiểm soát hệ thống phức tạp.'
                    ],
                    [
                        'title' => '💪 Điều kiện thành công',
                        'content' => 'Tuy nhiên, bạn sẽ chỉ phát huy tối đa khi học được cách tin vào bản thân, đối diện với áp lực từ kỳ vọng (cả bên ngoài lẫn nội tâm), và bước đi kiên định từng bước một.'
                    ]
                ]
            ],
            33 => [
                'title' => 'Số Trưởng Thành 33 – Master Teacher với tình yêu vô điều kiện',
                'calculation' => 'Tính từ tổng của Life Path Number và Expression Number',
                'interpretation' => 'Bắt đầu từ tuổi 35 trở đi, nếu bạn sở hữu Số Trưởng Thành 33 – bạn mang trong mình một sứ mệnh tinh thần đặc biệt cao quý. Đây là con số bậc thầy của tình yêu vô điều kiện, lòng vị tha và sự hy sinh cao cả, thường gắn liền với vai trò chữa lành, nuôi dưỡng và truyền cảm hứng sâu sắc cho cộng đồng.',
                'sections' => [
                    [
                        'title' => '💝 Sứ mệnh thiêng liêng',
                        'content' => 'Khi trưởng thành, bạn sẽ nhận ra mình không chỉ muốn thành công cho riêng mình, mà còn muốn giúp người khác trở nên tốt hơn, sống tử tế hơn và kết nối sâu sắc hơn với trái tim họ. Sự dịu dàng, nhân ái và tinh thần dẫn dắt bằng gương sáng chính là những điều khiến bạn tỏa sáng.'
                    ],
                    [
                        'title' => '🌟 Khả năng chữa lành',
                        'content' => 'Bạn có khả năng làm dịu tổn thương, cảm hóa bằng sự bao dung, và dùng chính trải nghiệm cá nhân của mình để giúp người khác vượt qua khó khăn.'
                    ],
                    [
                        'title' => '⚠️ Thách thức đặc biệt',
                        'content' => 'Đây là một hành trình không dễ – vì bạn thường cảm nhận sâu sắc nỗi đau của người khác, và dễ quên mất việc chăm sóc chính mình.'
                    ]
                ]
            ]
        ];
    }

    public static function getPersonalYearInterpretationsData()
    {
        return [
            1 => [
                'title' => 'Năm Cá Nhân Số 1 – Khởi Đầu Mới và Tự Chủ',
                'overview' => 'Năm này đánh dấu sự khởi động của một chu kỳ 9 năm mới trong cuộc đời bạn. Đây là năm bạn cần đứng lên làm chủ định hướng, hành động và quyết định cuộc đời mình. Những lựa chọn bạn đưa ra trong năm nay sẽ định hình toàn bộ hành trình 9 năm tới – vì vậy không nên xem nhẹ. Chú ý: Năm này không phải để nhìn lại quá khứ – mà là để vẽ bản đồ cho tương lai.',
                'career' => 'Nếu bạn đã ấp ủ một ý tưởng (kinh doanh, học ngành mới, thay đổi công việc), năm này là năm lý tưởng để bắt đầu. Bạn sẽ thấy mình trở nên quyết đoán hơn, ít bị chi phối bởi ý kiến bên ngoài. Nếu công việc hiện tại không còn phù hợp, bạn sẽ cảm thấy nội tâm thôi thúc phải thay đổi – đừng gạt đi tiếng gọi này. Có thể bạn sẽ bắt đầu lại từ con số 0 – nhưng điều đó hoàn toàn đúng tinh thần năm 1. Chú ý: Đây là năm bạn cần gieo hạt, chưa gặt hái ngay. Hãy kiên nhẫn với chính mình.',
                'financial' => 'Tài chính năm nay chưa phải lúc "bung lụa". Bạn nên đầu tư vào học hành, kỹ năng hoặc các công cụ phục vụ phát triển dài hạn. Ngoài ra nên tránh chi tiêu vì cảm xúc hoặc áp lực xã hội. Đây là năm của chi tiêu có chiến lược, không phải để chạy theo lợi nhuận nhanh. ⚠️ Đầu tư vào bản thân là khoản đầu tư sinh lời cao nhất trong năm nay.',
                'love' => 'Người độc thân: dễ gặp người mới, có cảm xúc nhưng thường chưa rõ ràng. Hãy cho mình và đối phương thời gian. Đang trong mối quan hệ: Sẽ có xu hướng cần không gian riêng để định hình bản thân. Nếu đã lâu không thấy đồng điệu, đây là lúc bạn cần nói chuyện thẳng thắn. Bạn cần tái kết nối với chính mình trước khi gắn bó sâu với ai khác. 💬 Không cần tránh tình yêu – nhưng đừng để nó làm bạn đánh mất định hướng.',
                'personalDevelopment' => 'Năm này là năm để làm mới bản sắc cá nhân: thay đổi lối sống, cách ăn mặc, tư duy, vai trò xã hội. Bạn sẽ thấy có cảm hứng để đọc sách về phát triển cá nhân, tâm lý, tư duy tích cực. Học một kỹ năng mới (ngoại ngữ, nghề tay trái, v.v.) Bắt đầu một thói quen: thiền, tập gym, viết nhật ký. 🔁 Bạn không cần thay đổi mọi thứ trong một ngày – chỉ cần bắt đầu đều đặn từng bước.',
                'opportunities' => ['Tự thiết kế cuộc đời theo cách của bạn', 'Xây dựng độc lập, tự chủ', 'Khởi động kế hoạch dài hạn'],
                'challenges' => ['Sợ hãi bắt đầu, do dự khi chưa thấy rõ kết quả', 'Dễ cô đơn vì người khác chưa "đi cùng nhịp"', 'Đòi hỏi kiên trì vì kết quả chưa đến ngay'],
                'universeMessage' => 'Mọi cây đại thụ cũng bắt đầu từ một hạt giống nhỏ. Bạn đang gieo điều gì cho 9 năm tới? Năm này là năm để bạn can đảm hành động, không cần hoàn hảo, chỉ cần bắt đầu. Hãy chọn điều thật sự quan trọng với bạn, và gieo từng bước với lòng tin vững chắc.'
            ],
            2 => [
                'title' => 'Năm Cá Nhân Số 2 – Hợp Tác và Cảm Xúc',
                'overview' => 'Năm này mang năng lượng của sự hợp tác, cảm xúc và tinh tế. Sau khi đã khởi động ở năm số 1, năm nay không phải là để "bật tốc độ", mà là để nuôi dưỡng, lắng nghe và làm sâu sắc mọi kết nối – cả bên trong lẫn bên ngoài. Chú ý: Đây là năm để trồng rễ, không phải trổ hoa. Thành công trong năm này đến từ sự kiên nhẫn, thấu hiểu và linh hoạt trong quan hệ.',
                'career' => 'Công việc có thể tiến triển chậm hơn bạn mong đợi – nhưng đây không phải dấu hiệu thất bại. Năm nay rất thích hợp để làm việc nhóm, xây dựng quan hệ đồng nghiệp, đối tác bền vững. Làm rõ quy trình, học hỏi kỹ năng bổ sung, lập nền tảng lâu dài. Nếu bạn đang tìm việc, đừng chỉ nhìn vị trí – hãy quan sát văn hóa tổ chức và giá trị tương đồng. 💡 Trong công việc, bạn sẽ "đi xa" nếu cùng ai đó đi chung – đừng cố "đi nhanh một mình".',
                'financial' => 'Đây không phải là năm của những bước nhảy vọt tài chính, nhưng bạn có thể duy trì sự ổn định nếu kiểm soát chi tiêu khéo léo. Có thể xuất hiện chi phí phát sinh liên quan đến người thân, gia đình hoặc mối quan hệ. Tránh đầu tư nóng hoặc nghe theo "truyền miệng" – trực giác của bạn tốt, nhưng nên xác minh kỹ trước khi hành động. ⚠️ Hãy coi tài chính là dòng nước: dòng chảy ổn định sẽ bền hơn là thác đổ ngắn hạn.',
                'love' => 'Người độc thân: có thể gặp người khiến bạn rung động nhẹ nhàng, sâu lắng – không phải tình yêu "bùng cháy", mà là kết nối bằng sự đồng cảm. Đang yêu hoặc kết hôn: Đây là năm bạn cần đặt cảm xúc lên bàn và trò chuyện chân thành. Nếu từng xảy ra tổn thương, năm nay là lúc chữa lành hoặc ra quyết định rõ ràng. Mối quan hệ dễ tổn thương vì hiểu lầm nhỏ – hãy học cách lắng nghe không phán xét. 💬 Tình yêu trong năm nay không cần rực rỡ – nhưng cần chân thành và có chiều sâu.',
                'personalDevelopment' => 'Năm này là năm bạn nên rèn luyện sự kiên nhẫn, kỹ năng giao tiếp cảm xúc, giải quyết mâu thuẫn. Đọc sách về tâm lý, EQ, giao tiếp bất bạo động, tình yêu trị liệu. Thực hành các thói quen giúp tái kết nối với nội tâm: thiền, viết nhật ký, đi bộ chậm, yoga. 🔁 Khi bạn kết nối được với chính mình, bạn sẽ kết nối tốt hơn với người khác.',
                'opportunities' => ['Xây dựng mối quan hệ sâu sắc và bền vững', 'Phát triển kỹ năng lắng nghe – ngoại giao', 'Học cách phối hợp – làm việc cùng người khác'],
                'challenges' => ['Dễ bị tổn thương vì quá nhạy cảm', 'Trì hoãn hành động vì quá sợ mâu thuẫn', 'Ghen tị, so sánh, thiếu kiên nhẫn khi thấy người khác tiến nhanh hơn'],
                'universeMessage' => 'Khi bạn đủ tĩnh lặng để lắng nghe, vũ trụ sẽ thì thầm điều bạn cần biết. Năm này không đòi hỏi bạn hành động mạnh, mà yêu cầu bạn trưởng thành từ bên trong. Hãy học cách đặt mình vào vị trí người khác, mở lòng đón nhận và yêu thương đúng cách – đó chính là "thành công" sâu sắc nhất trong năm nay.'
            ],
            3 => [
                'title' => 'Năm Cá Nhân Số 3 – Sáng Tạo và Giao Tiếp',
                'overview' => 'Năm này mang năng lượng của sự sáng tạo, giao tiếp và niềm vui. Sau khi đã trải qua năm cá nhân số 2 với sự hợp tác và kiên nhẫn, năm nay là thời điểm để bạn thể hiện bản thân, kết nối xã hội và tận hưởng cuộc sống.',
                'career' => 'Năm nay là thời điểm lý tưởng để bạn thể hiện sự sáng tạo trong công việc. Bạn có thể cảm thấy được truyền cảm hứng để bắt đầu các dự án mới hoặc đưa ra những ý tưởng độc đáo. Hãy tận dụng cơ hội để mở rộng mạng lưới quan hệ.',
                'financial' => 'Mặc dù năm nay mang lại nhiều cơ hội, nhưng bạn cần cẩn trọng trong việc quản lý tài chính. Tránh chi tiêu quá mức cho các hoạt động giải trí hoặc mua sắm không cần thiết. Hãy lên kế hoạch tài chính rõ ràng.',
                'love' => 'Năm nay, bạn sẽ cảm thấy dễ dàng kết nối với người khác, tạo dựng các mối quan hệ mới hoặc làm mới các mối quan hệ hiện tại. Hãy mở lòng và chia sẻ cảm xúc, điều này sẽ giúp bạn xây dựng những mối quan hệ sâu sắc và ý nghĩa hơn.',
                'personalDevelopment' => 'Đây là năm để bạn khám phá những sở thích mới, tham gia vào các hoạt động nghệ thuật hoặc học hỏi những kỹ năng mới. Hãy dành thời gian cho việc viết lách, vẽ tranh, âm nhạc hoặc bất kỳ hình thức sáng tạo nào mà bạn yêu thích.',
                'opportunities' => ['Thể hiện bản thân và khám phá sự sáng tạo', 'Mở rộng mạng lưới quan hệ xã hội', 'Tận hưởng niềm vui và sự lạc quan'],
                'challenges' => ['Dễ bị phân tâm và thiếu tập trung', 'Có thể bỏ qua các trách nhiệm quan trọng', 'Nguy cơ chi tiêu quá mức hoặc thiếu kỷ luật'],
                'universeMessage' => 'Hãy để ánh sáng bên trong bạn tỏa sáng, lan tỏa niềm vui và cảm hứng đến mọi người xung quanh. Năm này là thời điểm để bạn sống trọn vẹn với đam mê.'
            ],
            4 => [
                'title' => 'Năm Cá Nhân Số 4 – Xây Dựng và Ổn Định',
                'overview' => 'Sau một năm 3 sôi động với nhiều cảm xúc và ý tưởng, năm này yêu cầu bạn "xuống đất" và bắt tay xây dựng thực tế. Đây là năm để bạn ổn định cuộc sống, rèn kỷ luật và xây nền móng vững chắc cho các mục tiêu dài hạn. 🏗️ Nếu năm 1 gieo hạt, năm 4 là năm bạn xây hàng rào bảo vệ và chăm sóc khu vườn cuộc đời. Đây là năm không dành cho lối sống tùy hứng – thành công đến từ sự nỗ lực nhất quán, bền bỉ và có hệ thống.',
                'career' => 'Năm này là năm của sự tập trung, siêng năng và bền bỉ. Bạn có thể thấy áp lực công việc tăng và nhiệm vụ đòi hỏi chi tiết, kiên trì và quy củ. Đây là thời điểm tốt để xây dựng hệ thống làm việc rõ ràng, thiết lập mục tiêu 3–5 năm tới và chuyển hướng từ "thử nghiệm" sang "thi công thực tế". 💡 Bạn không cần làm quá nhiều việc – chỉ cần làm một việc đúng cách và đều đặn.',
                'financial' => 'Năm 4 là thời điểm lý tưởng để kiểm soát tài chính chặt chẽ. Bạn nên cắt giảm chi tiêu không cần thiết, tái cấu trúc ngân sách và ưu tiên tích lũy hoặc đầu tư cho lâu dài (mua tài sản, học nghề…). Không nên chạy theo lợi nhuận nhanh, dễ bị "sa lầy". ⚠️ Tài chính ổn định sẽ không đến từ may mắn – mà đến từ kỷ luật.',
                'love' => 'Tình cảm năm nay cần nền tảng chắc chắn. Người độc thân dễ cảm thấy cô đơn, vì năng lượng năm 4 thiên về công việc hơn lãng mạn. Tuy nhiên, nếu gặp ai đó nghiêm túc, mối quan hệ có thể phát triển rất vững chắc. Với người đang yêu: Đây là lúc cần tăng tính cam kết, xây niềm tin và hỗ trợ thực tế cho nhau. Tránh đổ lỗi, hãy cùng nhau "đắp gạch". 💬 Tình yêu trong năm 4 không rực rỡ – nhưng nếu vun trồng kỹ, sẽ lâu bền.',
                'personalDevelopment' => 'Đây là năm bạn cần xây dựng thói quen sống ổn định (giờ giấc, ăn uống, vận động). Sắp xếp lại không gian sống, gọn gàng hoá. Học cách quản lý thời gian và nguồn lực cá nhân. 🔁 Kỷ luật không giết cảm hứng – kỷ luật giải phóng bạn khỏi hỗn loạn.',
                'opportunities' => ['Xây dựng nền tảng sự nghiệp/tài chính ổn định', 'Học tính kỷ luật và tự quản', 'Rèn khả năng tổ chức, thực thi'],
                'challenges' => ['Cảm thấy bị bó buộc, chán nản với sự đơn điệu', 'Mất động lực nếu không thấy kết quả ngay lập tức', 'Dễ bị "quá lý trí", thiếu linh hoạt'],
                'universeMessage' => 'Bạn không cần đi nhanh hơn – chỉ cần tiếp tục đi, đúng hướng và đều đặn. Năm này không phải là năm "nổi bật", nhưng là năm quyết định bạn có đủ nền tảng để vươn cao ở năm 5, 6 hay không. Hãy chấp nhận nhịp sống chậm, tập trung, có kế hoạch – và bạn sẽ bất ngờ với thành quả trong tương lai gần.'
            ],
            5 => [
                'title' => 'Năm Cá Nhân Số 5 – Tự Do và Thay Đổi',
                'overview' => 'Năm này là thời điểm để bạn thoát khỏi những khuôn mẫu cũ và đón nhận sự thay đổi. Đây là năm của tự do cá nhân, phiêu lưu và khám phá. Bạn sẽ cảm thấy thôi thúc để thử những điều mới mẻ và mở rộng giới hạn của bản thân.',
                'career' => 'Năm nay, bạn sẽ cảm thấy tràn đầy năng lượng và khát khao đổi mới trong công việc. Đây là thời điểm lý tưởng để khởi động các dự án sáng tạo, thay đổi công việc hoặc lĩnh vực hoạt động, mở rộng mạng lưới quan hệ chuyên nghiệp.',
                'financial' => 'Với nhiều cơ hội mới, bạn có thể tăng thu nhập, nhưng cũng dễ chi tiêu quá mức cho các trải nghiệm mới. Hãy lập kế hoạch tài chính rõ ràng, ưu tiên đầu tư vào học tập và phát triển bản thân.',
                'love' => 'Năm nay, bạn sẽ có cơ hội gặp gỡ nhiều người mới và mở rộng mối quan hệ xã hội. Tuy nhiên, hãy cẩn trọng với các mối quan hệ thoáng qua. Nếu đang trong mối quan hệ, đây là thời điểm để hâm nóng tình cảm bằng những trải nghiệm mới cùng nhau.',
                'personalDevelopment' => 'Tham gia các khóa học ngắn hạn, du lịch, khám phá những nền văn hóa mới, thử sức với các hoạt động ngoài trời hoặc nghệ thuật. Hãy tận dụng năng lượng của năm 5 để mở rộng tầm nhìn và làm mới bản thân.',
                'opportunities' => ['Khám phá bản thân và thế giới xung quanh', 'Mở rộng mạng lưới quan hệ xã hội', 'Đón nhận cơ hội nghề nghiệp mới'],
                'challenges' => ['Dễ mất phương hướng nếu thiếu mục tiêu rõ ràng', 'Nguy cơ bị phân tán và thiếu tập trung', 'Rủi ro tài chính nếu không quản lý tốt'],
                'universeMessage' => 'Cuộc sống là một hành trình, không phải là điểm đến. Hãy tận hưởng từng bước đi. Năm này là thời điểm để bạn mở rộng giới hạn, đón nhận sự thay đổi và sống trọn vẹn với đam mê.'
            ],
            6 => [
                'title' => 'Năm Cá Nhân Số 6 – Trách Nhiệm và Tình Yêu',
                'overview' => 'Năm này là thời điểm để bạn tập trung vào gia đình, bạn bè và cộng đồng. Đây là năm của trách nhiệm, tình yêu và sự hài hòa. Bạn sẽ cảm thấy thôi thúc để chăm sóc người thân, cải thiện môi trường sống và xây dựng các mối quan hệ bền vững.',
                'career' => 'Năm nay, bạn sẽ cảm thấy cần thiết phải ổn định công việc và xây dựng mối quan hệ hợp tác vững chắc. Đây là thời điểm lý tưởng để tập trung vào các dự án dài hạn, xây dựng mối quan hệ tốt với đồng nghiệp và đối tác.',
                'financial' => 'Với nhiều trách nhiệm mới, bạn cần quản lý tài chính một cách cẩn thận. Hãy lập kế hoạch chi tiêu rõ ràng, ưu tiên cho các khoản chi liên quan đến gia đình và nhà cửa.',
                'love' => 'Năm nay, bạn sẽ có cơ hội củng cố và phát triển các mối quan hệ tình cảm. Đây là thời điểm để giải quyết các mâu thuẫn trong mối quan hệ hiện tại, tạo dựng mối quan hệ mới dựa trên sự tin tưởng và tôn trọng.',
                'personalDevelopment' => 'Tập trung vào việc xây dựng một cuộc sống cân bằng và hài hòa. Học cách quản lý thời gian để vừa hoàn thành trách nhiệm vừa chăm sóc bản thân. Phát triển kỹ năng lãnh đạo và quản lý.',
                'opportunities' => ['Xây dựng mối quan hệ gia đình vững chắc', 'Phát triển kỹ năng lãnh đạo và quản lý', 'Tạo dựng môi trường sống hài hòa'],
                'challenges' => ['Dễ bị quá tải vì nhận quá nhiều trách nhiệm', 'Nguy cơ bỏ qua nhu cầu cá nhân vì quá tập trung vào người khác', 'Căng thẳng tài chính do chi phí gia đình tăng'],
                'universeMessage' => 'Tình yêu thực sự là sự cân bằng giữa cho đi và nhận lại. Hãy chăm sóc người khác nhưng đừng quên chăm sóc chính mình.'
            ],
            7 => [
                'title' => 'Năm Cá Nhân Số 7 – Tâm Linh và Nội Tâm',
                'overview' => 'Năm này là thời điểm để bạn chuyển hướng tập trung vào thế giới bên trong. Đây là năm của sự chiêm nghiệm, học hỏi sâu sắc và phát triển tâm linh. Bạn sẽ cảm thấy thôi thúc để tìm hiểu bản chất sâu xa của cuộc sống.',
                'career' => 'Năm nay có thể là thời điểm chậm lại trong sự nghiệp, nhưng đây là cơ hội tuyệt vời để nghiên cứu, học hỏi và phát triển chuyên môn sâu. Tập trung vào chất lượng hơn là số lượng.',
                'financial' => 'Đây không phải là năm để mở rộng đầu tư hoặc chi tiêu lớn. Hãy tiết kiệm và đầu tư vào giáo dục, khóa học hoặc các hoạt động phát triển bản thân.',
                'love' => 'Mối quan hệ tình cảm có thể trải qua giai đoạn thử thách. Đây là thời điểm để hiểu sâu hơn về bản thân và những gì bạn thực sự cần trong một mối quan hệ.',
                'personalDevelopment' => 'Dành thời gian cho thiền định, đọc sách tâm linh, học hỏi triết học. Tìm hiểu về bản chất sâu xa của cuộc sống và vị trí của bạn trong vũ trụ.',
                'opportunities' => ['Phát triển trí tuệ và hiểu biết sâu sắc', 'Kết nối với tâm linh và nội tâm', 'Hoàn thiện bản thân từ bên trong'],
                'challenges' => ['Dễ cảm thấy cô đơn và tách biệt', 'Có thể trở nên quá nội tâm và tránh né xã hội', 'Nghi ngờ bản thân và mất phương hướng'],
                'universeMessage' => 'Trong sự tĩnh lặng, bạn sẽ tìm thấy những câu trả lời mà bạn đã tìm kiếm. Hãy tin vào hành trình nội tâm của mình.'
            ],
            8 => [
                'title' => 'Năm Cá Nhân Số 8 – Thành Tựu và Quyền Lực',
                'overview' => 'Năm này là thời điểm để gặt hái thành quả từ những nỗ lực trong chu kỳ 9 năm. Đây là năm của thành công vật chất, quyền lực và nhận diện. Bạn sẽ cảm thấy năng lượng mạnh mẽ để đạt được những mục tiêu lớn.',
                'career' => 'Đây là năm vàng cho sự nghiệp. Cơ hội thăng tiến, mở rộng kinh doanh hoặc đạt được vị trí lãnh đạo rất cao. Hãy tận dụng tối đa năng lượng này để đạt được những bước tiến quan trọng.',
                'financial' => 'Tài chính sẽ cải thiện đáng kể. Đây là thời điểm tốt để đầu tư, mở rộng kinh doanh hoặc thực hiện các khoản mua lớn. Tuy nhiên, hãy quản lý một cách khôn ngoan.',
                'love' => 'Mối quan hệ có thể bị ảnh hưởng bởi việc tập trung quá nhiều vào sự nghiệp. Hãy tìm cách cân bằng giữa thành công cá nhân và hạnh phúc gia đình.',
                'personalDevelopment' => 'Học cách lãnh đạo một cách hiệu quả và có trách nhiệm. Phát triển kỹ năng quản lý và khả năng đưa ra quyết định quan trọng.',
                'opportunities' => ['Đạt được thành tựu vật chất lớn', 'Giành được vị trí lãnh đạo và ảnh hưởng', 'Xây dựng di sản bền vững'],
                'challenges' => ['Nguy cơ trở nên tham lam hoặc áp bức', 'Có thể bỏ qua giá trị tinh thần vì quá tập trung vào vật chất', 'Căng thẳng cao do áp lực thành công'],
                'universeMessage' => 'Quyền lực thực sự đến từ việc sử dụng khả năng của mình để phục vụ điều thiện. Hãy nhớ trách nhiệm đi kèm với thành công.'
            ],
            9 => [
                'title' => 'Năm Cá Nhân Số 9 – Hoàn Thành và Chuyển Đổi',
                'overview' => 'Năm này đánh dấu sự kết thúc của chu kỳ 9 năm và chuẩn bị cho khởi đầu mới. Đây là năm để hoàn thành các dự án cũ, buông bỏ những gì không còn phù hợp và chuẩn bị cho giai đoạn mới.',
                'career' => 'Có thể là thời điểm để kết thúc một giai đoạn trong sự nghiệp hoặc chuyển sang hướng mới. Tập trung vào việc hoàn thành các dự án đang dang dở và chuẩn bị cho những bước tiến mới.',
                'financial' => 'Hãy cẩn thận với tài chính, tránh các khoản đầu tư rủi ro cao. Đây là thời điểm để thanh lý những tài sản không cần thiết và chuẩn bị tài chính cho chu kỳ mới.',
                'love' => 'Mối quan hệ có thể trải qua những thay đổi lớn. Đây là thời điểm để quyết định những mối quan hệ nào đáng giữ lại và những gì cần buông bỏ.',
                'personalDevelopment' => 'Phản tư về 9 năm vừa qua, rút ra bài học và chuẩn bị cho giai đoạn mới. Thực hành lòng từ bi, tha thứ và cho đi.',
                'opportunities' => ['Hoàn thành những mục tiêu chưa đạt được', 'Phục vụ cộng đồng và lan tỏa tình yêu thương', 'Chuẩn bị cho khởi đầu mới'],
                'challenges' => ['Khó khăn trong việc buông bỏ', 'Cảm giác mất mát hoặc kết thúc', 'Bất ổn cảm xúc do sự thay đổi lớn'],
                'universeMessage' => 'Mọi kết thúc đều là khởi đầu mới. Hãy tin tưởng vào chu kỳ tự nhiên của cuộc sống và chuẩn bị đón nhận những điều tuyệt vời sắp đến.'
            ]
        ];
    }

    public static function getInnateAbilitiesInterpretationsData()
    {
        return [
            'thể chất' => [
                0 => [
                    'title' => 'Năng lực thể chất',
                    'level' => 'thiếu hoàn toàn',
                    'description' => 'Bạn thiếu năng lượng thể chất trong tên, điều này cho thấy xu hướng thiếu kiên trì khi hành động, dễ trì hoãn và khó biến ý tưởng thành kết quả cụ thể. Bạn có thể thiên về tư duy, cảm xúc hoặc trực giác hơn là thực tiễn. Để cân bằng, bạn nên rèn luyện thói quen vận động nhẹ, làm việc đều đặn và hoàn thành từng việc nhỏ để tăng sức bền và tính ổn định.'
                ],
                1 => [
                    'title' => 'Năng lực thể chất',
                    'level' => 'thấp',
                    'description' => 'Bạn có năng lượng thể chất ở mức thấp. Điều này cho thấy bạn có thể bắt đầu hành động nhưng dễ mất đà, thiếu đều đặn và khó duy trì sức bền. Để phát triển, bạn nên tập trung vào việc rèn tính kỷ luật, tạo thói quen vận động và ưu tiên hoàn tất từng việc cụ thể thay vì chỉ lên kế hoạch.'
                ],
                2 => [
                    'title' => 'Năng lực thể chất',
                    'level' => 'trung bình',
                    'description' => 'Bạn sở hữu năng lượng thể chất ở mức trung bình. Bạn có khả năng hành động và làm việc thực tế, nhưng đôi khi thiếu ổn định hoặc dễ chán nếu không có động lực rõ ràng. Việc duy trì kỷ luật, tập luyện thể chất đều đặn và hoàn thành từng mục tiêu nhỏ sẽ giúp bạn củng cố nền tảng này vững chắc hơn.'
                ],
                3 => [
                    'title' => 'Năng lực thể chất',
                    'level' => 'khá mạnh',
                    'description' => 'Bạn có năng lực thể chất khá mạnh. Điều này cho thấy bạn là người thực tế, siêng năng và có khả năng duy trì hành động đều đặn. Bạn thường thích làm việc cụ thể, tổ chức không gian, hoặc vận động thân thể. Đây là điểm mạnh nên tiếp tục phát huy qua thói quen kỷ luật và các công việc mang tính hành động rõ ràng.'
                ],
                4 => [
                    'title' => 'Năng lực thể chất',
                    'level' => 'khá mạnh',
                    'description' => 'Bạn có năng lực thể chất khá mạnh. Điều này cho thấy bạn là người thực tế, siêng năng và có khả năng duy trì hành động đều đặn. Bạn thường thích làm việc cụ thể, tổ chức không gian, hoặc vận động thân thể. Đây là điểm mạnh nên tiếp tục phát huy qua thói quen kỷ luật và các công việc mang tính hành động rõ ràng.'
                ],
                'max' => [
                    'title' => 'Năng lực thể chất',
                    'level' => 'rất mạnh',
                    'description' => 'Bạn sở hữu năng lượng thể chất vượt trội. Bạn hành động nhanh, bền bỉ và có xu hướng giải quyết vấn đề thông qua thực tiễn. Sự siêng năng, ổn định và khả năng hoàn tất công việc là điểm nổi bật. Tuy nhiên, hãy cân bằng với nghỉ ngơi và cảm xúc để tránh làm việc quá sức hoặc chỉ tập trung vào hành động mà quên mất chiều sâu bên trong.'
                ]
            ],
            'cảm xúc' => [
                0 => [
                    'title' => 'Năng lực cảm xúc',
                    'level' => 'thiếu hoàn toàn',
                    'description' => 'Bạn không có chữ cái thuộc nhóm cảm xúc trong tên, điều này cho thấy bạn có xu hướng kiềm chế cảm xúc hoặc khó thể hiện tình cảm ra bên ngoài. Bạn thường lý trí, giữ khoảng cách và ít bị chi phối bởi cảm xúc cá nhân. Để cân bằng, bạn nên học cách lắng nghe cảm xúc của chính mình, cởi mở hơn trong chia sẻ và rèn luyện sự đồng cảm trong các mối quan hệ.'
                ],
                1 => [
                    'title' => 'Năng lực cảm xúc',
                    'level' => 'thấp',
                    'description' => 'Bạn có năng lượng cảm xúc ở mức thấp. Điều này cho thấy bạn ít thể hiện cảm xúc hoặc thường giữ riêng trong lòng. Bạn có thể gặp khó khăn khi diễn đạt tình cảm, đôi lúc bị hiểu lầm là lạnh lùng hay xa cách. Để cải thiện, bạn nên luyện tập lắng nghe cảm xúc bên trong, học cách chia sẻ một cách chân thành và cởi mở hơn trong các mối quan hệ cá nhân.'
                ],
                2 => [
                    'title' => 'Năng lực cảm xúc',
                    'level' => 'trung bình',
                    'description' => 'Bạn có mức cảm xúc ở ngưỡng cân bằng. Điều này cho thấy bạn biết quan tâm đến cảm xúc của mình và người khác, nhưng không quá nhạy cảm hay dễ bị tác động. Bạn thường giữ được sự điềm tĩnh trong giao tiếp, có thể lắng nghe và phản hồi tình cảm một cách vừa đủ. Khi cần, bạn nên cho phép bản thân thể hiện cảm xúc rõ ràng hơn để tăng sự kết nối sâu sắc trong các mối quan hệ.'
                ],
                3 => [
                    'title' => 'Năng lực cảm xúc',
                    'level' => 'khá mạnh',
                    'description' => 'Bạn sở hữu năng lượng cảm xúc khá mạnh, cho thấy bạn là người nhạy bén, giàu tình cảm và dễ đồng cảm với người khác. Bạn thường thể hiện cảm xúc một cách tự nhiên, chân thành và biết cách tạo kết nối ấm áp trong các mối quan hệ. Đây là một điểm mạnh trong giao tiếp và hỗ trợ người khác, nhưng cũng cần giữ sự ổn định để không bị cuốn theo cảm xúc quá mức.'
                ],
                4 => [
                    'title' => 'Năng lực cảm xúc',
                    'level' => 'khá mạnh',
                    'description' => 'Bạn sở hữu năng lượng cảm xúc khá mạnh, cho thấy bạn là người nhạy bén, giàu tình cảm và dễ đồng cảm với người khác. Bạn thường thể hiện cảm xúc một cách tự nhiên, chân thành và biết cách tạo kết nối ấm áp trong các mối quan hệ. Đây là một điểm mạnh trong giao tiếp và hỗ trợ người khác, nhưng cũng cần giữ sự ổn định để không bị cuốn theo cảm xúc quá mức.'
                ],
                'max' => [
                    'title' => 'Năng lực cảm xúc',
                    'level' => 'rất mạnh',
                    'description' => 'Bạn có năng lượng cảm xúc rất mạnh, cho thấy bạn là người sâu sắc, dễ rung động và thường sống thiên về cảm xúc. Bạn giàu lòng trắc ẩn, dễ đồng cảm, và thường nhạy cảm với không khí xung quanh. Tuy nhiên, nếu không cân bằng, bạn có thể dễ bị tổn thương, lo lắng hoặc phản ứng quá mức. Việc học cách điều tiết cảm xúc và giữ vững nội tâm sẽ giúp bạn phát huy tối đa sức mạnh tình cảm này.'
                ]
            ],
            'trí tuệ' => [
                0 => [
                    'title' => 'Năng lực trí tuệ',
                    'level' => 'thiếu hoàn toàn',
                    'description' => 'Bạn không có chữ cái thuộc nhóm trí tuệ (A, B, C, J, K, L, S, T, U) trong tên, điều này cho thấy bạn có thể thiếu xu hướng phân tích, lý luận logic hoặc tổ chức suy nghĩ một cách rõ ràng. Bạn có thể thiên về trực giác hoặc cảm xúc hơn là suy nghĩ lý tính. Để cân bằng, bạn nên rèn luyện khả năng lập kế hoạch, học cách đánh giá vấn đề một cách khách quan và phát triển tư duy phản biện để hỗ trợ cho các quyết định trong cuộc sống.'
                ],
                1 => [
                    'title' => 'Năng lực trí tuệ',
                    'level' => 'thấp',
                    'description' => 'Bạn có năng lượng trí tuệ ở mức thấp. Điều này cho thấy bạn có thể gặp khó khăn trong việc tổ chức suy nghĩ, phân tích logic hoặc xử lý thông tin một cách hệ thống. Bạn có xu hướng dựa vào cảm nhận hoặc hành động theo cảm xúc hơn là lập luận lý trí. Để cải thiện, bạn nên luyện tập kỹ năng tư duy phản biện, học cách đặt câu hỏi, và rèn thói quen lên kế hoạch rõ ràng cho các quyết định trong cuộc sống.'
                ],
                2 => [
                    'title' => 'Năng lực trí tuệ',
                    'level' => 'trung bình',
                    'description' => 'Bạn có năng lượng trí tuệ ở mức trung bình. Điều này cho thấy bạn có khả năng suy nghĩ rõ ràng, biết phân tích và đưa ra quyết định hợp lý khi cần. Tuy nhiên, bạn có thể không luôn dựa vào lý trí trong mọi tình huống, và đôi khi bị chi phối bởi cảm xúc hoặc trực giác. Việc duy trì thói quen quan sát, phản biện và sắp xếp suy nghĩ một cách có trật tự sẽ giúp bạn phát huy tốt hơn mặt mạnh này.'
                ],
                3 => [
                    'title' => 'Năng lực trí tuệ',
                    'level' => 'khá mạnh',
                    'description' => 'Bạn có năng lượng trí tuệ khá mạnh, cho thấy bạn suy nghĩ logic, biết phân tích và thường tiếp cận vấn đề một cách lý trí. Bạn có khả năng tổ chức, lên kế hoạch và đánh giá tình huống dựa trên lập luận rõ ràng. Đây là lợi thế trong học tập, công việc và các quyết định mang tính chiến lược. Tuy nhiên, bạn cũng cần lưu ý kết hợp hài hòa giữa lý trí và cảm xúc để giữ sự linh hoạt trong giao tiếp và hành động.'
                ],
                4 => [
                    'title' => 'Năng lực trí tuệ',
                    'level' => 'khá mạnh',
                    'description' => 'Bạn có năng lượng trí tuệ khá mạnh, cho thấy bạn suy nghĩ logic, biết phân tích và thường tiếp cận vấn đề một cách lý trí. Bạn có khả năng tổ chức, lên kế hoạch và đánh giá tình huống dựa trên lập luận rõ ràng. Đây là lợi thế trong học tập, công việc và các quyết định mang tính chiến lược. Tuy nhiên, bạn cũng cần lưu ý kết hợp hài hòa giữa lý trí và cảm xúc để giữ sự linh hoạt trong giao tiếp và hành động.'
                ],
                'max' => [
                    'title' => 'Năng lực trí tuệ',
                    'level' => 'rất mạnh',
                    'description' => 'Bạn có năng lượng trí tuệ vượt trội, cho thấy bạn là người suy nghĩ sâu sắc, phân tích sắc bén và thường lý trí trong hầu hết tình huống. Bạn giỏi tổ chức, học hỏi nhanh và có khả năng lập kế hoạch, tư duy hệ thống tốt. Đây là thế mạnh rõ rệt trong môi trường học thuật, công việc chuyên môn hoặc lãnh đạo. Tuy nhiên, hãy chú ý cân bằng với cảm xúc và trực giác để tránh trở nên quá cứng nhắc hoặc suy nghĩ quá mức.'
                ]
            ],
            'tinh thần' => [
                0 => [
                    'title' => 'Năng lực tinh thần',
                    'level' => 'thiếu hoàn toàn',
                    'description' => 'Bạn không có chữ cái thuộc nhóm tinh thần (F, G, H, I, O, P, Q, R, X, Y, Z) trong tên, điều này cho thấy bạn có xu hướng ít quan tâm đến thế giới nội tâm, tâm linh hoặc trực giác. Bạn thường thiên về hành động, lý trí hoặc cảm xúc cụ thể hơn là suy tư trừu tượng hay tìm kiếm ý nghĩa sâu xa. Để cân bằng, bạn nên dành thời gian chiêm nghiệm, kết nối với bản thân và lắng nghe trực giác để phát triển chiều sâu tinh thần.'
                ],
                1 => [
                    'title' => 'Năng lực tinh thần',
                    'level' => 'thấp',
                    'description' => 'Bạn có năng lượng tinh thần ở mức thấp, cho thấy bạn hiếm khi dựa vào trực giác hay quan tâm đến khía cạnh tâm linh, lý tưởng. Bạn thường sống thực tế, tập trung vào điều cụ thể trước mắt và ít khi đặt câu hỏi về ý nghĩa sâu xa. Tuy nhiên, việc dành thời gian cho suy ngẫm, thiền định hoặc tiếp xúc với tri thức tinh thần có thể giúp bạn mở rộng nhận thức và phát triển chiều sâu nội tâm.'
                ],
                2 => [
                    'title' => 'Năng lực tinh thần',
                    'level' => 'trung bình',
                    'description' => 'Bạn có năng lượng tinh thần ở mức cân bằng. Bạn có thể cảm nhận được trực giác hoặc lý tưởng nội tâm, nhưng không quá phụ thuộc vào chúng. Bạn biết lắng nghe bên trong khi cần, đồng thời vẫn giữ sự thực tế trong suy nghĩ và hành động. Việc duy trì kết nối với đời sống tinh thần qua thiền, sáng tạo hoặc chiêm nghiệm cá nhân sẽ giúp bạn phát triển sâu sắc hơn về nhận thức và định hướng sống.'
                ],
                3 => [
                    'title' => 'Năng lực tinh thần',
                    'level' => 'khá mạnh',
                    'description' => 'Bạn có năng lượng tinh thần khá mạnh, cho thấy bạn sống sâu sắc, có trực giác tốt và thường hướng đến những giá trị bên trong như ý nghĩa, mục đích sống hoặc tâm linh. Bạn dễ cảm nhận được điều người khác không nói ra, và có xu hướng tìm kiếm sự kết nối với điều gì đó lớn hơn bản thân. Đây là nền tảng tốt để phát triển chiều sâu nội tâm, miễn là bạn giữ được sự cân bằng với thực tế và cảm xúc.'
                ],
                4 => [
                    'title' => 'Năng lực tinh thần',
                    'level' => 'khá mạnh',
                    'description' => 'Bạn có năng lượng tinh thần khá mạnh, cho thấy bạn sống sâu sắc, có trực giác tốt và thường hướng đến những giá trị bên trong như ý nghĩa, mục đích sống hoặc tâm linh. Bạn dễ cảm nhận được điều người khác không nói ra, và có xu hướng tìm kiếm sự kết nối với điều gì đó lớn hơn bản thân. Đây là nền tảng tốt để phát triển chiều sâu nội tâm, miễn là bạn giữ được sự cân bằng với thực tế và cảm xúc.'
                ],
                'max' => [
                    'title' => 'Năng lực tinh thần',
                    'level' => 'rất mạnh',
                    'description' => 'Bạn có năng lượng tinh thần rất mạnh, cho thấy bạn sống hướng nội, nhạy bén về trực giác và thường bị thu hút bởi tâm linh, triết học hoặc những giá trị vượt lên trên đời sống vật chất. Bạn dễ kết nối với cảm hứng sáng tạo, lý tưởng sống hoặc chiều sâu tinh thần của người khác. Tuy nhiên, bạn cũng cần giữ sự cân bằng với hành động thực tế để không bị cuốn vào thế giới nội tâm mà thiếu nền tảng cụ thể.'
                ]
            ]
        ];
    }

    public static function calculateInnateAbilities($fullName)
    {
        $abilities = [
            'thể chất' => ['count' => 0, 'letters' => []],
            'cảm xúc' => ['count' => 0, 'letters' => []],
            'trí tuệ' => ['count' => 0, 'letters' => []],
            'tinh thần' => ['count' => 0, 'letters' => []]
        ];

        // Letter groups based on source code
        $letterGroups = [
            'thể chất' => ['D', 'M', 'V', 'đ', 'm', 'v'],
            'cảm xúc' => ['E', 'N', 'W', 'è', 'é', 'ẻ', 'ẹ', 'ẽ', 'ê', 'ề', 'ế', 'ể', 'ệ', 'ễ', 'e', 'n', 'w'],
            'trí tuệ' => ['A', 'B', 'C', 'J', 'K', 'L', 'S', 'T', 'U', 'à', 'á', 'ả', 'ạ', 'ã', 'â', 'ầ', 'ấ', 'ẩ', 'ậ', 'ẫ', 'ă', 'ằ', 'ắ', 'ẳ', 'ặ', 'ẵ', 'ù', 'ú', 'ủ', 'ụ', 'ũ', 'ư', 'ừ', 'ứ', 'ử', 'ự', 'ữ', 'a', 'b', 'c', 'j', 'k', 'l', 's', 't', 'u'],
            'tinh thần' => ['F', 'G', 'H', 'I', 'O', 'P', 'Q', 'R', 'X', 'Y', 'Z', 'ì', 'í', 'ỉ', 'ị', 'ĩ', 'ò', 'ó', 'ỏ', 'ọ', 'õ', 'ô', 'ồ', 'ố', 'ổ', 'ộ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ở', 'ợ', 'ỡ', 'ỳ', 'ý', 'ỷ', 'ỵ', 'ỹ', 'f', 'g', 'h', 'i', 'o', 'p', 'q', 'r', 'x', 'y', 'z']
        ];

        // Process name without spaces and special characters, but keep Vietnamese characters
        $name = preg_replace('/[^A-Za-zÀ-ỹĐđ]/u', '', $fullName);
        $chars = mb_str_split($name, 1, 'UTF-8');

        foreach ($chars as $originalChar) {
            // Check both original character and its normalized version
            $normalizedChar = str_replace(
                ['à', 'á', 'ả', 'ạ', 'ã', 'â', 'ầ', 'ấ', 'ẩ', 'ậ', 'ẫ', 'ă', 'ằ', 'ắ', 'ẳ', 'ặ', 'ẵ',
                 'è', 'é', 'ẻ', 'ẹ', 'ẽ', 'ê', 'ề', 'ế', 'ể', 'ệ', 'ễ',
                 'ì', 'í', 'ỉ', 'ị', 'ĩ',
                 'ò', 'ó', 'ỏ', 'ọ', 'õ', 'ô', 'ồ', 'ố', 'ổ', 'ộ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ở', 'ợ', 'ỡ',
                 'ù', 'ú', 'ủ', 'ụ', 'ũ', 'ư', 'ừ', 'ứ', 'ử', 'ự', 'ữ',
                 'ỳ', 'ý', 'ỷ', 'ỵ', 'ỹ', 'đ'],
                ['a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
                 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                 'i', 'i', 'i', 'i', 'i',
                 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
                 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
                 'y', 'y', 'y', 'y', 'y', 'd'],
                mb_strtolower($originalChar, 'UTF-8')
            );

            foreach ($letterGroups as $ability => $letters) {
                if (in_array($originalChar, $letters) || in_array($normalizedChar, $letters) ||
                    in_array(mb_strtoupper($originalChar, 'UTF-8'), $letters) ||
                    in_array(mb_strtoupper($normalizedChar, 'UTF-8'), $letters)) {
                    $abilities[$ability]['count']++;
                    $abilities[$ability]['letters'][] = $originalChar;
                    break; // Each letter belongs to only one group
                }
            }
        }

        return $abilities;
    }

    private static function removeVietnameseAccents($str)
    {
        $accents = [
            'à', 'á', 'ả', 'ạ', 'ã', 'â', 'ầ', 'ấ', 'ẩ', 'ậ', 'ẫ', 'ă', 'ằ', 'ắ', 'ẳ', 'ặ', 'ẵ',
            'è', 'é', 'ẻ', 'ẹ', 'ẽ', 'ê', 'ề', 'ế', 'ể', 'ệ', 'ễ',
            'ì', 'í', 'ỉ', 'ị', 'ĩ',
            'ò', 'ó', 'ỏ', 'ọ', 'õ', 'ô', 'ồ', 'ố', 'ổ', 'ộ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ở', 'ợ', 'ỡ',
            'ù', 'ú', 'ủ', 'ụ', 'ũ', 'ư', 'ừ', 'ứ', 'ử', 'ự', 'ữ',
            'ỳ', 'ý', 'ỷ', 'ỵ', 'ỹ',
            'đ'
        ];

        $replaced = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd'
        ];

        return str_replace($accents, $replaced, $str);
    }

    /**
     * Calculate innate abilities with interpretations for complete profile
     */
    public static function calculateInnateAbilitiesWithInterpretations($fullName)
    {
        $abilities = self::calculateInnateAbilities($fullName);
        $abilitiesWithInterpretations = [];

        // Map Vietnamese ability names to English keys for consistency
        $abilityMapping = [
            'thể chất' => 'physical',
            'cảm xúc' => 'emotional',
            'trí tuệ' => 'intellectual',
            'tinh thần' => 'spiritual'
        ];

        foreach ($abilities as $vietnameseName => $abilityData) {
            $englishName = $abilityMapping[$vietnameseName] ?? $vietnameseName;
            // Use Vietnamese name for interpretation lookup
            $interpretation = self::getInnateAbilitiesInterpretation($vietnameseName, $abilityData['count']);

            $abilitiesWithInterpretations[$englishName] = [
                'count' => $abilityData['count'],
                'letters' => $abilityData['letters'],
                'title' => $interpretation['title'],
                'level' => $interpretation['level'],
                'description' => $interpretation['description']
            ];
        }

        return $abilitiesWithInterpretations;
    }

    public static function getInnateAbilitiesInterpretation($abilityName, $letterCount)
    {
        $interpretationsData = self::getInnateAbilitiesInterpretationsData();

        if (!isset($interpretationsData[$abilityName])) {
            return [
                'title' => 'Năng lực ' . $abilityName,
                'level' => 'không xác định',
                'description' => 'Chưa có dữ liệu diễn giải cho năng lực này.'
            ];
        }

        $abilityData = $interpretationsData[$abilityName];

        // Determine level based on letter count
        if ($letterCount == 0) {
            return $abilityData[0];
        } elseif ($letterCount == 1) {
            return $abilityData[1];
        } elseif ($letterCount == 2) {
            return $abilityData[2];
        } elseif ($letterCount <= 4) {
            return $abilityData[3];
        } else {
            return $abilityData['max'];
        }
    }
}