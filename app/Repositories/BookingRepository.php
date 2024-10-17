<?php
namespace App\Repositories;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingRepository extends BaseRepository
{

    public function getModel()
    {
        return Booking::class;
    }
    public function getAllBookedDates()
    {
        return Booking::all(['check_in_date', 'check_out_date'])->toArray();
    }

    public function createBooking($customer_info, $room_ids, $check_in_date, $check_out_date, $voucher_code, $user_id)
    {
        DB::beginTransaction();
        try {
            $discount = 0; // % giảm giá
            $voucher_id = null;
            if ($voucher_code) {
                $voucher = Voucher::where('code', $voucher_code)->first();
                if ($voucher) {
                    $discount = $voucher->discount_amount;
                    $voucher_id = $voucher->id;
                }
            }
            $total_price = 0;
            $dataInsert = [];
            foreach ($room_ids as $room_id) {
                $room = Room::find($room_id)->load('roomType');
                $total_price += $room->roomType->price;

                $dataInsert[] = [
                    'user_id' => $user_id,
                    'customer_info' => json_encode($customer_info), // Ensure customer_info is JSON encoded
                    'room_id' => $room_id,
                    'voucher_id' => $voucher_id,
                    'check_in_date' => $check_in_date,
                    'check_out_date' => $check_out_date,
                    'total_price' => $room->roomType->price,
                    'amount_payable' => $room->roomType->price - ($room->roomType->price * $discount / 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $total_price = $total_price - ($total_price * $discount / 100);

            if ($dataInsert) {
                Booking::insert($dataInsert);
                DB::commit();

                return response()->json(['success' => 'Booking created successfully'], 201);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating booking: ' . $e->getMessage());
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại sau'], 500);
        }
    }

    public function getBookingByUser($user_id)
    {

        return Booking::where('user_id', $user_id)->with(['order','room'])->get();
    }

    public function getAll($limit = 0, $latest = false, $p = [])
    {
        $query = Booking::query();

        if (!empty($p) && count($p) > 0) {
            // Validate that each element in $p is a string
            $validRelationships = array_filter($p, 'is_string');
            if (count($validRelationships) > 0) {
                $query->with($validRelationships);
            }
        }

        if ($latest) {
            $query->orderBy('created_at', 'desc');
        }

        if ($limit > 0) {
            return $query->limit($limit)->get();
        }

        return $query->get();
    }
}
