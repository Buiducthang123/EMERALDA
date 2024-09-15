<?php
namespace App\Services;

use App\Repositories\FeatureRepository;

class FeatureService
{
    protected $featureRepository;

    public function __construct(FeatureRepository $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }

    public function getAll()
    {
        return $this->featureRepository->getAll();
    }

    public function update($id, $data)
    {
        return $this->featureRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->featureRepository->delete($id);
    }

    public function create($data)
    {
        return $this->featureRepository->create($data);
    }

}
