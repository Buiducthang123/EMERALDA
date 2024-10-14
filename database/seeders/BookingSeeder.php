<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
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
            $check_out_date = (clone $check_in_date)->modify('+' . rand(1, 14) . ' days');

            Booking::create([
                'user_id' => $faker->randomElement($user_ids),
                'room_id' => $faker->randomElement($room_ids),
                'customer_info' => json_encode([
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'birthday' => $faker->date('Y-m-d'),
                ]),
                'check_in_date' => $check_in_date,
                'check_out_date' => $check_out_date,
            ]);
        }
    }
}
