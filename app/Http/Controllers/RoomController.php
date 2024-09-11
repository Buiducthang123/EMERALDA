<?php

namespace App\Http\Controllers;

use App\Services\RoomService;
use Illuminate\Http\Request;

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
    public function store(Request $request): never
    {
        abort(404);
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
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
