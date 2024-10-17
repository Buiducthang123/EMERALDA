<?php

namespace App\Enums;
class PaymentStatus
{
    const UNPAID = 1; // chưa thanh toán
    const DEPOSIT = 2; // đã đặt cọc
    const PAID = 3; // đã thanh toán
    const FAILED = 4;  // thất bại

    public static function getValues()
    {
        return [
            self::UNPAID,
            self::DEPOSIT,
            self::PAID,
            self::FAILED,
        ];
    }
}
