<?php

namespace Database\Seeders;

use App\Enums\RoomStatus;
use App\Models\Feature;
use App\Models\Room;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            // Create a new room record using Faker data
            Room::create([
                'room_number' => $faker->unique()->numberBetween(100, 999),
                'room_type_id' => $faker->numberBetween(1, 3),
                'status' => RoomStatus::AVAILABLE,
                'description' => $faker->sentence,
            ]);
        }
    }
}
