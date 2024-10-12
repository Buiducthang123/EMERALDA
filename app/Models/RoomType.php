<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'intro_description', 'description', 'slug', 'main_image', 'thumbnails', 'amenities', 'max_people', 'price', 'area'];

    protected $appends = ['total_rooms'];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'status' => 'integer',
            'thumbnails' => 'array',
            'amenities' => 'array',
            'description' => 'string',
        ];
    }

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

    public function getTotalRoomsAttribute()
    {
        return $this->rooms()->where('room_type_id', $this->id)->count();
    }



}
