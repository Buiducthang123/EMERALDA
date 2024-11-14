<?php

namespace App\Exports;

use App\Models\Invoice;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatiscalExport implements FromCollection, WithHeadings
{
    protected $timeRange;

    /**
     * Class constructor.
     */
    public function __construct($timeRange)
    {
        $this->timeRange = $timeRange;
    }

    public function collection()
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $this->timeRange['start'])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $this->timeRange['end'])->endOfDay();
        // $startDate = Carbon::createFromFormat('d/m/Y', $this->timeRange['start'])->startOfDay();
        // $endDate = Carbon::createFromFormat('d/m/Y', $this->timeRange['end'])->endOfDay();
        return Invoice::with(['booking.room', 'booking.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get()
            ->map(function ($invoice) {
                return [
                    'ID' => $invoice->id,
                    'Booking ID' => $invoice->booking->id,
                    'Room' => $invoice->booking->room->name,
                    'User' => $invoice->booking->user->name,
                    'Email'=> $invoice->booking->user->email,
                    'Total Amount' => $invoice->total_amount,
                    'Created At' => $invoice->created_at->format('d/m/Y H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Booking ID', 'Room', 'User','Email', 'Total Amount', 'Created At'];
    }
}
