<?php

namespace App\Services;

use App\Repositories\BookingRepository;

class BookingService
{
    protected $bookingRepo;

    public function __construct(BookingRepository $bookingRepo)
    {
        $this->bookingRepo = $bookingRepo;
    }

    public function getAllBookedDates()
    {
        return $this->bookingRepo->getAllBookedDates();
    }

    public function createBooking($data, $user_id)
    {
        if($user_id == null) {
            return response()->json(['message' => 'Vui lòng đăng nhập'], 401);
        }

        $customer_info = $data['customer_info'];
        if ($customer_info['name'] == null || $customer_info['email'] == null || $customer_info['phone_number'] == null || $customer_info['address'] == null || $customer_info['birthday'] == null) {
            return response()->json(['message' => 'Vui lòng nhập đủ thông tin khách hảng'], 400);
        }

        $room_ids = $data['rooms'] ?? [];
        $check_in_date = $data['check_in_date'] ?? null;
        $check_out_date = $data['check_out_date'] ?? null;
        if($check_in_date >= $check_out_date) {
            return response()->json(['message' => 'Ngày check-in phải nhỏ hơn ngày check-out'], 400);
        }
        if(count($room_ids) == 0) {
            return response()->json(['message' => 'Vui lòng chọn ít nhất 1 phòng'], 400);
        }
        $voucher_code = $data['voucher_code'] ?? null;

        return $this->bookingRepo->createBooking($customer_info, $room_ids, $check_in_date, $check_out_date, $voucher_code, $user_id);
    }

}
