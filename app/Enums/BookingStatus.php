<?php
namespace App\Enums;

class BookingStatus
{
    const PENDING = 1; // chờ xác nhận
    const CONFIRMED = 2; // đã xác nhận
    const CHECKED_IN = 3; // đã nhận phòng
    const CHECKED_OUT = 4; // đã trả phòng
    const CANCELLED = 5; // đã hủy

    public static function getValues()
    {
        return [
            self::PENDING,
            self::CONFIRMED,
            self::CHECKED_IN,
            self::CHECKED_OUT,
            self::CANCELLED,
        ];
    }
}
