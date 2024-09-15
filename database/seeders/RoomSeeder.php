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

        $feature = Feature::pluck("id")->toArray();

        for ($i = 0; $i < 10; $i++) {
            // Create a new room record using Faker data
            Room::create([
                'room_number' => $faker->unique()->numberBetween(100, 999),
                'room_type_id' => $faker->numberBetween(1, 5),
                'main_image' => $faker->imageUrl(),
                'thumbnails' => ['https://phunugioi.com/wp-content/uploads/2020/04/anh-gai-xinh-hot-girl-nhat-ban.jpg', 'https://img2.thuthuatphanmem.vn/uploads/2019/02/22/anh-nen-gai-xinh-cho-may-tinh_121749947.jpg'],
                'status' => RoomStatus::AVAILABLE,
                'price' => $faker->randomFloat(2, 50, 200),
                'features' => [1,3],
                'description' => $faker->sentence,
                'amenities' => [1.2,3],
                'area' => $faker->numberBetween(20, 100),
                'adults' => $faker->numberBetween(1, 4),
                'children' => $faker->numberBetween(0, 2),
            ]);
        }
    }
}
