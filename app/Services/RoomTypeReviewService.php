<?php
namespace App\Services;

use App\Models\Room;
use App\Models\RoomTypeReview;
use App\Repositories\RoomTypeReviewRepository;
use Illuminate\Support\Facades\Auth;

class RoomTypeReviewService
{
    protected $roomTypeReviewRepository;

    public function __construct(RoomTypeReviewRepository $roomTypeReviewRepository)
    {
        $this->roomTypeReviewRepository = $roomTypeReviewRepository;
    }
    public function create($data)
    {
        $data['user_id'] = Auth::id();
        $roomTypeId = Room::find($data['room_id'])->room_type_id;
        $data['room_type_id'] = $roomTypeId;
        $result = RoomTypeReview::create($data);
        if ($result) {
            return $result;
        }
        return false;
    }

    public function getAll($data)
    {
        $limit = $data['limit'] ?? 0;
        $latest = $data['latest'] ?? true;
        $q = $data['q'] ?? [];
        $result = $this->roomTypeReviewRepository->getAll($limit, $latest, $q);
        return $result;
    }

    public function delete($id)
    {
        $result = $this->roomTypeReviewRepository->delete($id);
        return $result;
    }
}
