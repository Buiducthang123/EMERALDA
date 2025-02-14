<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTypeReview extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'booking_id',
        'room_type_id',
        'rating',
        'comment',
    ];

    protected $table = 'room_type_reviews';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

}
