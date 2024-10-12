<?php
namespace App\Repositories;

use App\Models\Booking;

class BookingRepository extends BaseRepository{

    public function getModel()
    {
        return Booking::class;
    }
    public function getAllBookedDates()
    {
        return Booking::all(['check_in_date', 'check_out_date'])->toArray();
    }

}
