<?php


namespace App\Helpers;

class NguHanhRelationHelper
{

public static function isSinh(string $hanh1, string $hanh2): bool
{
    // Kiểm tra nếu 1 trong 2 hành không hợp lệ
    if (!in_array($hanh1, DataHelper::$NGU_HANH, true) || !in_array($hanh2, DataHelper::$NGU_HANH, true)) {
        return false;
    }

    // Trả về true nếu hanh1 sinh hanh2
    return isset(DataHelper::$SINH_RELATIONS[$hanh1]) 
        && DataHelper::$SINH_RELATIONS[$hanh1] === $hanh2;
}

public static function isKhac(string $hanh1, string $hanh2): bool
{
    // Kiểm tra nếu 1 trong 2 hành không hợp lệ
    if (!in_array($hanh1, DataHelper::$NGU_HANH, true) || !in_array($hanh2, DataHelper::$NGU_HANH, true)) {
        return false;
    }

    // Trả về true nếu hanh1 khắc hanh2
    return isset(DataHelper::$KHAC_RELATIONS[$hanh1]) 
        && DataHelper::$KHAC_RELATIONS[$hanh1] === $hanh2;
}

}
