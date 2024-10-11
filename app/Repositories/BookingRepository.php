<?php
namespace App\Repositories;

use App\Models\Booking;

class BookingRepository extends BaseRepository{

    public function getModel()
    {
        return Booking::class;
    }
}
