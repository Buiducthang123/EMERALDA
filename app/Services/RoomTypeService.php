<?php

namespace App\Services;

use App\Enums\RoomStatus;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Repositories\RoomTypeRepository;
use Illuminate\Support\Facades\Log;

class RoomTypeService
{
    protected $roomTypeRepo;

    public function __construct(RoomTypeRepository $roomTypeRepo)
    {
        $this->roomTypeRepo = $roomTypeRepo;
    }

    public function updateRoomType($data, $id)
    {
        try {
            $result = $this->roomTypeRepo->update($id, $data);
            if ($result) {
                return response()->json([
                    "message" => "Cập nhật thành công",
                ], 200);
            } else {
                return response()->json([
                    "message" => "Cập nhật thất bại",
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->roomTypeRepo->delete($id);
            if ($result) {
                return response()->json([
                    "message" => "Xóa thành công",
                ], 200);
            } else {
                return response()->json([
                    "message" => "Xóa thất bại",
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function create($data)
    {
        try {
            $result = $this->roomTypeRepo->create($data);
            if ($result) {
                return response()->json([
                    "message" => "Tạo mới thành công",
                ], 200);
            } else {
                return response()->json([
                    "message" => "Tạo mới thất bại",
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function getRoomType($id, $slug, $q = [])
    {
        $result = $this->roomTypeRepo->getRoomType($id, $slug, $q);
        return $result;
    }

    public function getAll($limit = 0, $latest = false, $q = [], $filterRoomBooking = null)
    {
        $query = new RoomType();

        if ($latest) {
            $query = $query->latest();
        }

        if ($limit > 0) {
            $query = $query->limit($limit);
        }

        $data = $query->get();

        if (in_array('rooms', $q)) {
            foreach ($data as $key => $value) {
                $rooms = Room::where('room_type_id', $value->id)->get();

                // Kiểm tra và thêm thuộc tính canBook nếu có filterRoomBooking
                if ($filterRoomBooking) {
                    $startDate = $filterRoomBooking['startDate'] ?? null;
                    $endDate = $filterRoomBooking['endDate'] ?? null;

                    if (!$startDate || !$endDate) {
                        Log::error('Missing startDate or endDate in filterRoomBooking.', ['filterRoomBooking' => $filterRoomBooking]);
                    } elseif (!strtotime($startDate) || !strtotime($endDate)) {
                        Log::error('Invalid date format for startDate or endDate.', ['startDate' => $startDate, 'endDate' => $endDate]);
                    } else {
                        foreach ($rooms as $room) {
                            $validStatuses = RoomStatus::getValues();

                            // Kiểm tra trạng thái của phòng
                            if ($room->status == RoomStatus::MAINTENANCE || !in_array($room->status, $validStatuses)) {
                                $room->canBook = false;
                                continue;
                            }
                            $hasBooking = Booking::where('room_id', $room->id)
                                ->where(function ($query) use ($startDate, $endDate) {
                                    $query->whereBetween('check_in_date', [$startDate, $endDate])
                                        ->orWhereBetween('check_out_date', [$startDate, $endDate])
                                        ->orWhere(function ($query) use ($startDate, $endDate) {
                                            $query->where('check_in_date', '<=', $startDate)
                                                ->where('check_out_date', '>=', $endDate);
                                        });
                                })
                                ->exists();

                            $room->canBook = !$hasBooking;
                        }
                    }
                }

                $data[$key]['rooms'] = $rooms;
            }
        }

        if (in_array('amenities', $q)) {
            foreach ($data as $key => $value) {
                $amenities_ids = $value->amenities;
                $data[$key]['amenities'] = Amenity::whereIn('id', $amenities_ids)->pluck('name')->toArray();
            }
        }

        return $data;
    }
}
