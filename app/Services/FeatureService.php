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


}
