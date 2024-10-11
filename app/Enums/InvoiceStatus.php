<?php
namespace App\Enums;

class InvoiceStatus{
    const PAID = 1;
    const UNPAID = 2;
    const CANCELLED = 3;

    public static function getValues()
    {
        return [
            self::PAID,
            self::UNPAID,
            self::CANCELLED,
        ];
    }
}
