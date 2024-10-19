<?php
namespace App\Enums;

class CancellationRequestStatus
{
    const PENDING = 1; // Chờ
    const WAITING_COMPLETE = 2; // Chờ hoàn thành
    const REJECTED = 3; // Từ chối
    const CANCELLED = 4; // Đã hủy
    const COMPLETED = 5; // Đã hoàn thành

     public static function getValues()
    {
        return [
            self::PENDING,
            self::WAITING_COMPLETE,
            self::REJECTED,
            self::CANCELLED,
            self::COMPLETED,
        ];
    }
}
