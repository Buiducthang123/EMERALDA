<?php
namespace App\Enums;

class BookingStatus
{
    const PENDING = 'pending'; // chờ xác nhận
    const CONFIRMED = 'confirmed'; // đã xác nhận
    const CHECKED_IN = 'checked_in'; // đã nhận phòng
    const CHECKED_OUT = 'checked_out'; // đã trả phòng
    const CANCELLED = 'cancelled'; // đã hủy

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
