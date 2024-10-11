<?php
namespace App\Services;

use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomType;
use App\Repositories\RoomTypeRepository;

class RoomTypeService
{
    protected $roomTypeRepo;
    public function __construct( RoomTypeRepository $roomTypeRepo)
    {
        $this->roomTypeRepo = $roomTypeRepo;
    }

    public function updateRoomType($data, $id)
    {
        try {
            $result = $this->roomTypeRepo->update($id, $data);
            if ($result) {
                return response()->json([
                    "message" => "Cập nhật thành công"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Cập nhật thất bại"
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id){
        try {
            $result = $this->roomTypeRepo->delete($id);
            if ($result) {
                return response()->json([
                    "message" => "Xóa thành công"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Xóa thất bại"
                ], status: 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function create($data){
        try {
            $result = $this->roomTypeRepo->create($data);
            if ($result) {
                return response()->json([
                    "message" => "Tạo mới thành công"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Tạo mới thất bại"
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function getRoomType($id,$slug, $q = []){
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
                $data[$key]['rooms'] = Room::where('room_type_id', $value->id)->get();
            }
        }
        if(in_array('amenities', $q)){
            foreach ($data as $key => $value) {
                $amenities_ids = $value->amenities;
                $data[$key]['amenities'] = Amenity::whereIn('id', $amenities_ids)->pluck('name')->toArray();
            }
        }
        $filterRoomBooking = json_decode($filterRoomBooking, true);
        return $data;
    }
}
