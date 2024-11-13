<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomTypeRequest;
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

    public function index(Request $request)
    {
        $filterRoomBooking = json_decode($request->get('filterRoomBooking', null), true);
        $q = $request->get('q', []);
        $limit = $request->get('limit', 0);
        $latest = $request->get('latest', false);
        return $this->roomTypeService->getAll( $limit, $latest, $q, $filterRoomBooking);
    }

    public function update(RoomTypeRequest $request, $id)
    {
        return $this->roomTypeService->updateRoomType($request->all(), $id);
    }

    public function create(RoomTypeRequest $request)
    {
        return $this->roomTypeService->create($request->all());
    }

    public function getRoomType($identifier, Request $request)
    {
        $q = $request->get('q', []);
        $id = $identifier;
        $slug = null;
        if (is_numeric($identifier)) {
            $id = $identifier;
        } else {
            $slug = $identifier;
        }
        return $this->roomTypeService->getRoomType($id, $slug, $q);
    }

    public function delete($id)
    {
        return $this->roomTypeService->delete($id);
    }

}
