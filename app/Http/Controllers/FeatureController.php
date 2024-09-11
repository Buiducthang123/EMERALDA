<?php

namespace App\Http\Controllers;

use App\Services\FeatureService;

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


}
