<?php

namespace App\Http\Controllers;

use App\Enums\RoomStatus;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    protected $roomService;

    /**
     * Class constructor.
     */
    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }
    /**
     * Show the form for creating the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'room_type_id' => $request->room_type_id,
            'status' => $request->status,
            'room_number' => $request->room_number
        ];
       return $this->roomService->getAllRooms($filters);
    }
    public function create(): never
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roomStatus = RoomStatus::getValues();
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', $roomStatus),
            'room_type_id' => 'required',
            'main_image' => 'required',
            'area' => 'required',
            'adults' => 'required',
            'children' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return $this->roomService->createRoom($request->all());
    }

    /**
     * Display the resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request, $id): mixed
    {
        $roomStatus = RoomStatus::getValues();
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', $roomStatus),
            'room_type_id' => 'required',
            'main_image' => 'required',
            'area' => 'required',
            'adults' => 'required',
            'children' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return $this->roomService->updateRoom($id, $request->all());
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }

    public function delete($id)
    {
        return $this->roomService->deleteRoom($id);
    }
}
