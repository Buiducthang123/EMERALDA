<?php

namespace App\Http\Controllers;

use App\Repositories\InvoiceRepository;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    protected $invoiceRepository;

    /**
     * Class constructor.
     */
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }
    public function store(Request $request)
    {
        return $this->invoiceRepository->create($request->all());
    }

    public function findByBooking(Request $request)
    {
        $booking_id = $request->booking_id;
        if(!$booking_id){
            return response()->json(['message' => 'Booking ID bắt buộc'], 400);
        }
        return $this->invoiceRepository->findByBooking($booking_id);
    }

    public function updateStatus(Request $request)
    {
        $booking_id = $request->booking_id;
        $status = $request->status;
        if(!$booking_id || !$status){
            return response()->json(['message' => 'Booking ID và status bắt buộc'], 400);
        }
        return $this->invoiceRepository->updateStatus($booking_id, $status);
    }

    public function me()
    {
        return $this->invoiceRepository->me();
    }

    public function getAll(Request $request)
    {
        $limit = $request->limit ? $request->limit : 10;
        $latest = $request->latest ? $request->latest : true;
        $q = $request->q ? $request->q : [];
        return $this->invoiceRepository->getAll($limit, $latest, $q);
    }


}
