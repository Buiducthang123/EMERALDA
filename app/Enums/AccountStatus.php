<?php
namespace App\Enums;

class AccountStatus {

    const ACTIVE = 1;
    const BLOCKED = 2;

    public static function getValues()
    {
        return [
            self::ACTIVE,
            self::BLOCKED,
        ];
    }
}
