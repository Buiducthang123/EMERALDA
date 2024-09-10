<?php
namespace App\Repositories;

use App\Models\RoomType;

class RoomTypeRepository extends BaseRepository
{
    public function getModel()
    {
        return RoomType::class;
    }
}
