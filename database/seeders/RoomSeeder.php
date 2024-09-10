<?php

namespace Database\Seeders;

use App\Enums\RoomStatus;
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
                'room_type_id' => $faker->numberBetween(1, 5),
                'main_image' => $faker->imageUrl(),
                'thumbnails' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
                'status' => $faker->randomElement(RoomStatus::getValues()),
                'price' => $faker->randomFloat(2, 50, 200),
                'description' => $faker->sentence,
                'amenities' => json_encode([$faker->word, $faker->word, $faker->word]),
                'adults' => $faker->numberBetween(1, 4),
                'children' => $faker->numberBetween(0, 2),
            ]);
        }
    }
}
