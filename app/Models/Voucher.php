<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_amount',
        'valid_from',
        'valid_until',
    ];

    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'room_type_voucher');
    }
}
