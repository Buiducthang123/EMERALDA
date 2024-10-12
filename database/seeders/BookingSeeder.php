<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Enums\BookingStatus;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $room_ids = Room::all()->pluck('id')->toArray();

        $faker = \Faker\Factory::create();

        foreach (range(1, 2) as $index) {
            $check_in_date = $faker->dateTimeBetween('-1 month', '+1 month');
            $check_out_date = (clone $check_in_date)->modify('+'.rand(1, 14).' days');

            Booking::create([
                'user_id' => $faker->randomElement($user_ids),
                'room_id' => $faker->randomElement($room_ids),
                'check_in_date' => $check_in_date,
                'check_out_date' => $check_out_date,
                'status' => $faker->randomElement(BookingStatus::getValues()),
                'max_people' => $faker->numberBetween(1, 4),
                'deposit_paid' => $faker->boolean,
                'total_price' => $faker->randomFloat(2, 50, 1000),
            ]);
        }
    }
}
