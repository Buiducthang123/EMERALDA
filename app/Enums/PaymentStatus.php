<?php

namespace App\Enums;
class PaymentStatus
{
    const PENDING = 1;
    const PAID = 2;
    const FAILED = 3;

    public static function getValues()
    {
        return [
            self::PENDING,
            self::PAID,
            self::FAILED,
        ];
    }
}
