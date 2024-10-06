<?php
namespace App\Services;

use App\Repositories\RoomTypeRepository;

class RoomTypeService
{
    protected $roomTypeRepo;
    public function __construct( RoomTypeRepository $roomTypeRepo)
    {
        $this->roomTypeRepo = $roomTypeRepo;
    }
    public function getAllRoomTypes(){
        return $this->roomTypeRepo->getAll();
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
}
