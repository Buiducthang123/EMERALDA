<?php
namespace App\Services;

use App\Enums\RoomStatus;
use App\Repositories\RoomRepository;
use Illuminate\Support\Facades\DB;

class RoomService
{
    protected $roomRepo;
    public function __construct( RoomRepository $roomRepo)
    {
        $this->roomRepo = $roomRepo;
    }

    public function getAllRooms($filters = []){
        return $this->roomRepo->getAllRooms($filters);
    }
    public function updateRoom($id, $data){
        return $this->roomRepo->update($id, $data);
    }

    public function createRoom( $data){
        return $this->roomRepo->create($data);
    }

    public function deleteRoom($id){
        DB::beginTransaction();
        try {
            $room = $this->roomRepo->find($id);
            if ($room) {
                if ($room->status != RoomStatus::BOOKED) {
                    $room->amenities()->detach();
                    $room->features()->detach();
                    $room->delete();
                    DB::commit();
                    return response()->json(['message' => 'Xoá thành công'], 200);
                } else if ($room->status == RoomStatus::AVAILABLE) {
                    DB::rollBack();
                    return response()->json(['message'=> 'Không thể xoá phòng này do đang được sử dụng'], status: 500);
                }
            }
            DB::rollBack();
            return response()->json(['message'=> 'Có lỗi xảy ra'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=> 'Có lỗi xảy ra', 'error' => $e->getMessage()], 500);
        }
    }
}
