<?php

namespace App\Http\Controllers;

use App\Services\FeatureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class FeatureController extends Controller
{
    //
    protected $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }

    public function index(){
        return $this->featureService->getAll();
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            "name"=> "required",
            'description' => 'required',
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return $this->featureService->update($id, $request->all());
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return $this->featureService->create($request->all());
    }

    public function delete($id){
        return $this->featureService->delete($id);
    }

}
