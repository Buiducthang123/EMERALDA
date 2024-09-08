<?php
namespace App\Enums;

class RoomStatus
{
    const AVAILABLE = 1; // có sẵn
    const BOOKED = 2; // đã đặt
    const MAINTENANCE = 3; // bảo trì

    public static function getValues()
    {
        return [
            self::AVAILABLE,
            self::BOOKED,
            self::MAINTENANCE,
        ];
    }
}
