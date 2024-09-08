<?php

namespace App\Enums;
class PaymentStatus
{
    const PENDING = 'pending';
    const PAID = 'paid';
    const FAILED = 'failed';

    public static function getValues()
    {
        return [
            self::PENDING,
            self::PAID,
            self::FAILED,
        ];
    }
}
