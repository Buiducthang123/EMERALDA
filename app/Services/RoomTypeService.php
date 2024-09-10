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
}
