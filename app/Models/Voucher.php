<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'main_image',
        'code',
        'discount_amount',
        'valid_from',
        'valid_until',
    ];

    public function casts(){
        return [
            'valid_from' => 'string',
            'valid_until' => 'string',
            'discount_amount' => 'integer',
        ];
    }

    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'room_type_voucher');
    }
}
