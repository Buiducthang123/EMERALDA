<?php
namespace App\Enums;

class RoomStatus
{
    const AVAILABLE = 'available'; // có sẵn
    const BOOKED = 'booked'; // đã đặt
    const MAINTENANCE = 'maintenance'; // bảo trì

    public static function getValues()
    {
        return [
            self::AVAILABLE,
            self::BOOKED,
            self::MAINTENANCE,
        ];
    }
}
