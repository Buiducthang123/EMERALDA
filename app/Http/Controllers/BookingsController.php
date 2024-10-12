<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    protected $bookingService;

    /**
     * Class constructor.
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
    //
    public function getAllBookedDates()
    {
        return $this->bookingService->getAllBookedDates();
    }
}
