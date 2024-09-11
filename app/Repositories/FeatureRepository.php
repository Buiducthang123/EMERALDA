<?php
namespace App\Repositories;

use App\Models\Feature;

class FeatureRepository extends BaseRepository
{
    public function getModel()
    {
        return Feature::class;
    }
}
