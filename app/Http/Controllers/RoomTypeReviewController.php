<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Repositories\RoomTypeReviewRepository;
use App\Services\RoomTypeReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomTypeReviewController extends Controller
{
    //

    protected $roomTypeReviewService;

    /**
     * Class constructor.
     */
    /**
     * Class constructor.
     */
    public function __construct(RoomTypeReviewService $roomTypeReviewService)
    {
        $this->roomTypeReviewService = $roomTypeReviewService;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return $this->roomTypeReviewService->create($data);
    }

    public function getAll(Request $request)
    {
        return $this->roomTypeReviewService->getAll($request->all());
    }

    public function delete($id)
    {
        return $this->roomTypeReviewService->delete($id);
    }
}
