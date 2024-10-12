<?php

namespace App\Services;

use App\Repositories\BookingRepository;

class BookingService {
    protected $bookingRepo;

    public function __construct(BookingRepository $bookingRepo)
    {
        $this->bookingRepo = $bookingRepo;
    }

    public function getAllBookedDates()
    {
        return $this->bookingRepo->getAllBookedDates();
    }
}
