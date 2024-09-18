<?php

namespace App\Http\Controllers;

use App\Services\RoomTypeService;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    //
    protected $roomTypeService;

    /**
     * Class constructor.
     */
    public function __construct(RoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;
    }

    public function index()
    {
        return $this->roomTypeService->getAllRoomTypes();
    }

    public function update(Request $request, $id)
    {
        return $this->roomTypeService->updateRoomType($request, $id);
    }

}
