<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_info',
        'room_id',
        'check_in_date',
        'check_out_date',

    ];

    public function cats()
    {
        return [
            'customer_info' => 'json',
        ];
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }


}
