<?php
namespace App\Enums;

class UserRole
{
    const GUEST = 1; //Khách hàng
    const RECEPTIONIST = 2; //Lễ tân
    const MANAGER = 3; // QUản lý
    const ADMIN = 4; // Quản trị viên

    public static function getValues()
    {
        return [
            self::GUEST,
            self::RECEPTIONIST,
            self::MANAGER,
            self::ADMIN,
        ];
    }
}
