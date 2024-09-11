<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Feature::create([
            'name' => 'Phòng tắm riêng',
            'description'=> 'Phòng tắm riêng',
        ]);

        Feature::create([
            'name' => 'Phòng ngủ riêng',
            'description'=> 'Phòng ngủ riêng',
        ]);

        Feature::create([
            'name' => 'Phòng khách riêng',
            'description'=> 'Phòng khách riêng',
        ]);

        Feature::create([
            'name' => 'Phòng bếp',
            'description'=> 'Phòng bếp',
        ]);

        Feature::create([
            'name' => 'Phòng ăn',
            'description'=> 'Phòng ăn',
        ]);
    }
}
