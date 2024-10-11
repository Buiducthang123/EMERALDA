<?php
namespace App\Repositories;

use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomType;

class RoomTypeRepository extends BaseRepository
{
    public function getModel()
    {
        return RoomType::class;
    }

    public function getRoomType($id, $slug, $q)
    {
        $data = [];
        if ($id) {
            $result = $this->model->find($id);
            if ($result) {
                $data = $result;
            }

            if ($slug) {
                $result = $this->model->where('slug', $slug)->first();
                if ($result) {
                    $data = $result;
                }
            }
            if (in_array('amenities', $q)) {
                $amenities_ids = $data->amenities;
                $data['amenities'] = Amenity::whereIn('id', $amenities_ids)->pluck('name')->toArray();
            }
            if (in_array('rooms', $q)) {
                $data['rooms'] = Room::where('room_type_id', $data->id)->get();
            }
            return $data;
        }
    }

    public function findBooking($data)
    {

    }


}
