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

    public function updateRoomType($request, $id)
    {
        try {
            $result = $this->roomTypeRepo->update($request, $id);
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
}
