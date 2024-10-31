<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'total_price',
        'paid_amount',
        'customer_info',
        'room_id',
        'check_in_date',
        'check_out_date',

    ];

    // public function getStatusAttribute($value)
    // {
    //     $bookingStatus = new BookingStatus();
    //     return $bookingStatus->getLabel($value);
    // }

    public function cats()
    {
        return [
            'customer_info' => 'json',
        ];
    }

    public function getStatusAttribute($value)
    {
        return (integer)$value;
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function room_type_reviews()
    {
        return $this->hasMany(RoomTypeReview::class);
    }

}
