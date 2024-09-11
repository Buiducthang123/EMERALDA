<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Amenity::create([
            "name" => "Wi-Fi",
            "description" => "Free Wi-Fi is available in all areas.",
        ]);
        Amenity::create([
            "name" => "Parking",
            "description" => "Free private parking is available on site.",
        ]);
        Amenity::create([
            "name" => "Airport Shuttle",
            "description" => "Airport shuttle is available at an additional charge.",
        ]);
        Amenity::create([
            "name" => "Swimming Pool",
            "description" => "Outdoor pool is available.",
        ]);
        Amenity::create([
            "name" => "Fitness Center",
            "description" => "Fitness center is available.",
        ]);
        Amenity::create([
            "name" => "Spa",
            "description" => "Spa and wellness center is available.",
        ]);
        Amenity::create([
            "name" => "Bar",
            "description" => "Bar is available.",
        ]);
        Amenity::create([
            "name" => "Restaurant",
            "description" => "Restaurant is available.",
        ]);

    }
}
