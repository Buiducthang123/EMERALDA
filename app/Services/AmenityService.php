<?php
namespace App\Services;

use App\Repositories\AmenityRepository;

class AmenityService {

    protected $amenityRepository;

    /**
     * Class constructor.
     */
    public function __construct(AmenityRepository $amenityRepository)
    {
        $this->amenityRepository = $amenityRepository;
    }

    public function getAll(){
        return $this->amenityRepository->getAll();
    }
}
