<?php
namespace App\Enums;

class UserRole
{
    const GUEST = 'guest'; //Khách hàng
    const RECEPTIONIST = 'receptionist'; //Lễ tân
    const MANAGER = 'manager'; // QUản lý
    const ADMIN = 'admin'; // Quản trị viên

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
