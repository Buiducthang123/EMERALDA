<?php
namespace App\Services;

use App\Repositories\RoomRepository;

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
}
