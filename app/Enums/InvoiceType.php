<?php
namespace App\Enums;

class InvoiceType{
    const DEPOSIT = 1; // đặt cọc
    const FULL_PAYMENT = 2; // thanh toán đủ

    public static function getValues()
    {
        return [
            self::DEPOSIT,
            self::FULL_PAYMENT,
        ];
    }
}
