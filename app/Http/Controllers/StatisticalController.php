<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{
    public function statistical(Request $request)
    {
        // Parse the range parameter
        $range = json_decode($request->input('range'), true);
        $startDate = Carbon::createFromFormat('d/m/Y', $range['start'])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $range['end'])->endOfDay();

        // Pie chart data - Room status
        $statusData = [
            'labels' => ['Họạt động', 'Bảo trì'],
            'datasets' => [
                [
                    'label' => 'Trạng thái phòng',
                    'backgroundColor' => ['#36A2EB','#FF6384'],
                    'data' => [],
                ],
            ],
        ];
        $totalRooms = Room::count();
        $statusCounts = Room::select('status', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get();

        $statusPercentages = $statusCounts->map(function ($item) use ($totalRooms) {
            return ($item->count / $totalRooms) * 100;
        });
        $totalPercentage = $statusPercentages->sum();
        if ($totalPercentage < 100) {
            $statusPercentages->push(100 - $totalPercentage);
        }
        else {
            $statusPercentages->push(0);
        }
        $statusData['datasets'][0]['data'] = $statusPercentages->values()->toArray();

        // Bar chart data - Monthly booking counts
        $bookingBar = [
            'labels' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            'datasets' => [
                [
                    'label' => 'Số lượng phòng đã đặt',
                    'backgroundColor' => '#42A5F5',
                    'data' => [], // Dynamic data
                ],
            ],
        ];

        $bookingCounts = Booking::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
            ->where('status', '!=', BookingStatus::CANCELLED)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->get();

        $monthlyCounts = array_fill(0, 12, 0);

        // Populate the array with the counts from the query results
        foreach ($bookingCounts as $bookingCount) {
            $monthlyCounts[$bookingCount->month - 1] = $bookingCount->count;
        }

        $bookingBar['datasets'][0]['data'] = $monthlyCounts;

        // Revenue by room type
        $roomTypeName = RoomType::pluck('name');

        $room_type_revenue = RoomType::with(['rooms.bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])
            ->get()
            ->map(function ($roomType) {
                return $roomType->rooms->map(function ($room) {
                    return $room->bookings->sum('total_price');
                })->sum();
            });

        $revenue_by_room_type = [
            'labels' => $roomTypeName,
            'datasets' => [
                [
                    'label' => 'Doanh thu',
                    'backgroundColor' => '#42A5F5',
                    'data' => $room_type_revenue->values()->toArray(),
                ],
            ],
        ];

        // Monthly revenue for the current year
        $currentYear = Carbon::now()->year;

        $monthlyRevenue = Booking::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as revenue'))
            ->whereYear('created_at', $currentYear)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->get();

        $revenueData = array_fill(0, 12, 0);

        foreach ($monthlyRevenue as $revenue) {
            $revenueData[$revenue->month - 1] = $revenue->revenue;
        }

        $revenueTrend = [
            'labels' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            'datasets' => [
                [
                    'label' => 'Doanh thu',
                    'backgroundColor' => '#42A5F5',
                    'borderColor'=> '#42A5F5',
                    'data' => $revenueData, // Dynamic data
                    'fill'=> false
                ],
            ],
        ];

        // Total revenue
        $totalRevenueTakeIn = Invoice::where('type', InvoiceType::PAYMENT)
            ->where('status', InvoiceStatus::PAID)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalRevenueTakeOut = Invoice::where('type', InvoiceType::REFUND)
            ->where('status', InvoiceStatus::PAID)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalRevenue = $totalRevenueTakeIn - $totalRevenueTakeOut;

        // Total users
        $totalUser = User::count();

        // Total rooms
        $totalRoom = Room::count();

        return response()->json([
            'statusData' => $statusData,
            'bookingBar' => $bookingBar,
            'revenue_by_room_type' => $revenue_by_room_type,
            'revenueTrend' => $revenueTrend,
            'totalRevenue' => $totalRevenue,
            'totalUser' => $totalUser,
            'totalRoom' => $totalRoom
        ]);
    }
}
