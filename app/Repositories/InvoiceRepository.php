<?php
namespace App\Repositories;

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return Invoice::class;
    }

    public function create($data = [])
    {
        $booking_id = $data['booking_id'];
        $services = $data['services'];

        $booking = Booking::find($booking_id);
        $room_rate = $booking->total_price;
        $paid_amount = $booking->paid_amount;
        $total_amount = $room_rate - $paid_amount;
        $service_price = $data['service_price'];

        $invoice = $this->model->firstOrNew(['booking_id' => $booking_id]);
        $invoice->services = $services;
        $invoice->total_amount = $total_amount + $service_price - $paid_amount;
        $invoice->type = InvoiceType::PAYMENT;
        $invoice->status = InvoiceStatus::UNPAID;
        $invoice->save();
        return $invoice;
    }

    public function findByBooking($booking_id)
    {
        return $this->model->where('booking_id', $booking_id)->first();
    }

    public function updateStatus($booking_id, $status)
    {
        $invoice = $this->model->where('booking_id', $booking_id)->first();
        $invoice->status = $status;
        $invoice->save();
        return $invoice;
    }

    public function me() {
        $user = Auth::user();
        return $this->model->where('user_id', $user->id)->get();
    }
}
