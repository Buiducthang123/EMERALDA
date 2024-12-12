<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
use App\Exports\StatiscalExport;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class StatisticalController extends Controller
{
    public function statistical(Request $request)
    {
        // Parse the range parameter
        $range = json_decode($request->input('range'), true);
        $startDate = Carbon::createFromFormat('d/m/Y', $range['start'])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $range['end'])->endOfDay();

        // Determine the interval for the revenue trend chart
        $interval = $startDate->diffInDays($endDate) > 31 ? 'month' : 'week';

        // Pie chart data - Room status
        $statusData = [
            'labels' => ['Hoạt động', 'Bảo trì'],
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
        } else {
            $statusPercentages->push(0);
        }
        $statusData['datasets'][0]['data'] = $statusPercentages->values()->toArray();

        // Bar chart data - Booking counts
        $bookingBar = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Số lượng phòng đã đặt',
                    'backgroundColor' => '#42A5F5',
                    'data' => [], // Dynamic data
                ],
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'stepSize' => 1,
                            'callback' => 'function(value) { return Number.isInteger(value) ? value : null; }',
                        ],
                    ],
                ],
            ],
        ];

        if ($interval === 'week') {
            $bookingBar['labels'] = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'];
            $weeklyBookingCounts = Booking::select(
                DB::raw('WEEK(created_at, 1) as week'),
                DB::raw('count(*) as count')
            )
            ->where('status', '!=', BookingStatus::CANCELLED)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('week')
            ->get();

        // Khởi tạo mảng đếm booking cho 4 tuần với giá trị mặc định là 0
        $weeklyCounts = array_fill(0, 4, 0);

        // Duyệt qua kết quả để tính số lượng booking cho từng tuần trong tháng
        foreach ($weeklyBookingCounts as $bookingCount) {
            // Tính tuần trong tháng của từng booking
            $weekIndex = Carbon::parse($bookingCount->created_at)->weekOfMonth - 1; // trừ đi 1 vì tuần trong tháng bắt đầu từ 1

            // Chỉ cập nhật các tuần nằm trong khoảng từ 0 đến 3 (4 tuần)
            if ($weekIndex >= 0 && $weekIndex < 4) {
                $weeklyCounts[$weekIndex] = $bookingCount->count;
            }
        }

        // Gán dữ liệu booking vào mảng kết quả
        $bookingBar['datasets'][0]['data'] = $weeklyCounts;

        } else {
            $bookingBar['labels'] = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
            $monthlyBookingCounts = Booking::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                ->where('status', '!=', BookingStatus::CANCELLED)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('month')
                ->get();

            $monthlyCounts = array_fill(0, 12, 0);

            foreach ($monthlyBookingCounts as $bookingCount) {
                $monthlyCounts[$bookingCount->month - 1] = $bookingCount->count;
            }

            $bookingBar['datasets'][0]['data'] = $monthlyCounts;
        }

        // Revenue by room type
        $roomTypeName = RoomType::pluck('name');

        $room_type_revenue = RoomType::with(['rooms.bookings' => function ($query) use ($startDate, $endDate) {
            $query->where('status', '!=', BookingStatus::CANCELLED)
                  ->whereBetween('created_at', [$startDate, $endDate]);
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

        // Revenue trend data
        $revenueTrend = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Doanh thu',
                    'backgroundColor' => '#42A5F5',
                    'borderColor'=> '#42A5F5',
                    'data' => [], // Dynamic data
                    'fill'=> false
                ],
            ],
        ];

        if ($interval === 'week') {
            $revenueTrend['labels'] = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'];
            $weeklyRevenue = Invoice::select(
                DB::raw('WEEK(created_at, 1) as week'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('status', InvoiceStatus::PAID)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('week')
            ->get();

            // Khởi tạo mảng doanh thu cho 4 tuần với giá trị mặc định là 0
            $weeklyCounts = array_fill(0, 4, 0);  // Dự tính có tối đa 4 tuần trong mỗi tháng

            // Duyệt qua kết quả để tính doanh thu cho từng tuần trong tháng
            foreach ($weeklyRevenue as $revenue) {
                // Tính tuần trong tháng của từng invoice
                $weekIndex = Carbon::parse($revenue->created_at)->weekOfMonth - 1; // trừ đi 1 vì tuần trong tháng bắt đầu từ 1

                // Chỉ cập nhật các tuần nằm trong khoảng từ 0 đến 3 (4 tuần)
                if ($weekIndex >= 0 && $weekIndex < 4) {
                    $weeklyCounts[$weekIndex] = $revenue->revenue;
                }
            }

            // Gán dữ liệu doanh thu vào mảng kết quả
            $revenueTrend['datasets'][0]['data'] = $weeklyCounts;

        } else {
            $revenueTrend['labels'] = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
            $monthlyRevenue = Invoice::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_amount) as revenue'))
                ->where('status', InvoiceStatus::PAID)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('month')
                ->get();

            $revenueData = array_fill(0, 12, 0);

            foreach ($monthlyRevenue as $revenue) {
                $revenueData[$revenue->month - 1] = $revenue->revenue;
            }

            $revenueTrend['datasets'][0]['data'] = $revenueData;
        }

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
    public function export(Request $request)
    {
        $range = json_decode($request->input('range'), true);
        return Excel::download(new StatiscalExport($range), 'statiscal.xlsx');
    }
}
