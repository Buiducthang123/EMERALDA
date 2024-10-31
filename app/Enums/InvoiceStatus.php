<?php
namespace App\Enums;

class InvoiceStatus{
    const PAID = 1; // Đã thanh toán
    const UNPAID = 2; // Chưa thanh toán
    const CANCELLED = 3; // Đã hủy

    public static function getValues()
    {
        return [
            self::PAID,
            self::UNPAID,
            self::CANCELLED,
        ];
    }
}
