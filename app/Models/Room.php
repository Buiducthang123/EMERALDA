<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType; // Add this line

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type_id',
        'main_image',
        'thumbnails',
        'status',
        'price',
        'description',
        'amenities',
        'adults',
        'children',
        'total_guests',
    ];

    protected $casts = [
        'thumbnails' => 'array',
        'amenities' => 'array',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_room');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_room');
    }
}
