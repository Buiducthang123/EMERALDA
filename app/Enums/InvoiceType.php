<?php
namespace App\Enums;

class InvoiceType{
    const PAYMENT = 1; // thanh toán
    const REFUND = 2; // hoàn tiền

    public static function getValues()
    {
        return [
            self::PAYMENT,
            self::REFUND,
        ];
    }
}
