<?php
namespace App\Enums;

class InvoiceType{
    const DEPOSIT = 'deposit';
    const FULL_PAYMENT = 'full_payment';

    public static function getValues()
    {
        return [
            self::DEPOSIT,
            self::FULL_PAYMENT,
        ];
    }
}
