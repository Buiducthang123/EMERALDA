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

    public function getAll($data){
        $limit = $data['limit'] ?? 0;
        $latest = $data['latest'] ?? false;
        $q = $data['q'] ?? [];
        return $this->amenityRepository->getAll($limit, $latest, $q);
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
