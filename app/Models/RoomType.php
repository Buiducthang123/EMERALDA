<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Thiết lập mối quan hệ với model Room
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function roomTypeReviews()
    {
        return $this->hasMany(RoomTypeReview::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'room_type_voucher');
    }
}
