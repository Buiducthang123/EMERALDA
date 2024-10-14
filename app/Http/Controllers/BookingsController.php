<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;
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

    public function createBooking(Request $request)
    {
        $user_id = Auth::id();
        return $this->bookingService->createBooking($request->all(), $user_id);
    }
}
