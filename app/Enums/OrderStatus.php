<?php

namespace App\Enums;

class OrderStatus
{
    const PENDING = 1; // chờ xác nhận
    const CONFIRMED = 2; // đã xác nhận
    const CANCELLED = 3; // đã hủy

    public static function getValues()
    {
        return [
            self::PENDING,
            self::CONFIRMED,
            self::CANCELLED,
        ];
    }
}
