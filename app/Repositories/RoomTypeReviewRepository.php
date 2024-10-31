<?php
namespace App\Repositories;

use App\Models\RoomTypeReview;

class RoomTypeReviewRepository extends BaseRepository
{
    public function getModel()
    {
        return RoomTypeReview::class;
    }
}
