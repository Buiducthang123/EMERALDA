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

    public function update($id, $data){
        return $this->amenityRepository->update($id, $data);
    }

    public function create($data){
        return $this->amenityRepository->create($data);
    }

    public function delete($id){
        return $this->amenityRepository->delete($id);
    }
}
