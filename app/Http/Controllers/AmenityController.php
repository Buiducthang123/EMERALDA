<?php

namespace App\Http\Controllers;

use App\Services\AmenityService;

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
}
