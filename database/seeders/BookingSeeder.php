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

        }
    }
}
