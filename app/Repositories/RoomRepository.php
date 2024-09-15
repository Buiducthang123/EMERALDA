<?php
namespace App\Repositories;

use App\Models\Room;

class RoomRepository extends BaseRepository
{
    public function getModel()
    {
        return Room::class;
    }

    public function getAllRooms( array $filters = [])
    {
        $query = $this->model->query();
        if (isset($filters['room_type_id'])) {
            $query->where('room_type_id', $filters['room_type_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['room_number'])) {
            $query->where('room_number', 'like', '%' . $filters['room_number'] . '%');
        }

        return $query->with(['roomType'])->latest()->paginate(5);
    }

}
