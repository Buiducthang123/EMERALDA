<?php

namespace App\Http\Controllers;

use App\Services\AmenityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmenityController extends Controller
{
    //
    protected $amenityService;

    public function __construct(AmenityService $amenityService)
    {
        $this->amenityService = $amenityService;
    }

    public function index(){
        return $this->amenityService->getAll();
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            "name"=> "required",
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return $this->amenityService->update($id, $request->all());
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return $this->amenityService->create($request->all());
    }

    public function delete($id){
        return $this->amenityService->delete($id);
    }
}
