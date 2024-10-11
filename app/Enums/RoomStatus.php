<?php
namespace App\Enums;

class RoomStatus
{
    const AVAILABLE = 1; // có sẵn
    const MAINTENANCE = 2; // bảo trì

    public static function getValues()
    {
        return [
            self::AVAILABLE,
            self::MAINTENANCE,
        ];
    }
}
