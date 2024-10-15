<?php
namespace App\Enums;

class BookingStatus
{
    const PENDING = 1; // chờ xác nhận
    const NOT_CHECKED_IN = 2; // chưa nhận phòng
    const CHECKED_IN = 3; // đã nhận phòng
    const CHECKED_OUT = 4; // đã trả phòng
    const CANCELLED = 5; // đã hủy

    public static function getValues()
    {
        return [
            self::PENDING,
            self::NOT_CHECKED_IN,
            self::CHECKED_IN,
            self::CHECKED_OUT,
            self::CANCELLED,
        ];
    }

    public function getLabel($status)
    {
        switch ($status) {
            case self::PENDING:
                return 'Chờ xác nhận';
            case self::NOT_CHECKED_IN:
                return 'Chưa nhận phòng';
            case self::CHECKED_IN:
                return 'Đã nhận phòng';
            case self::CHECKED_OUT:
                return 'Đã trả phòng';
            case self::CANCELLED:
                return 'Đã hủy';
            default:
                return 'Không xác định';
        }
    }
}
