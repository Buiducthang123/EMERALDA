<?php
namespace App\Repositories;

use App\Models\Amenity;

class AmenityRepository extends BaseRepository{

    public function getModel(){
       return Amenity::class;
    }


}
