<?php

namespace App\Enums;
class PaymentStatus
{
    const PENDING = 1; // chờ xử lý
    const DEPOSIT = 2; // đã đặt cọc
    const PAID = 3; // đã thanh toán
    const FAILED = 4;  // thất bại

    public static function getValues()
    {
        return [
            self::PENDING,
            self::DEPOSIT,
            self::PAID,
            self::FAILED,
        ];
    }
}
