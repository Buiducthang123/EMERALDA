<?php
namespace App\Enums;

class CancellationRequestStatus
{
    const PENDING = 0; // Chờ
    const WAITING_COMPLETE = 1; // Chờ hoàn thành
    const REJECTED = 2; // Từ chối
    const CANCELLED = 3; // Đã hủy
    const COMPLETED = 4; // Đã hoàn thành

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
