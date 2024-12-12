<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Order;
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

        Order::all()->each(function ($order) use ($faker) {
            foreach (range(1, rand(1, 3)) as $index) {
                $checkInDate = $faker->dateTimeBetween('-12 months', 'now');
                $checkOutDate = $faker->dateTimeBetween($checkInDate, $checkInDate->format('Y-m-d') . ' +7 days');

                Booking::create([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'room_id' => Room::inRandomOrder()->first()->id,
                    'check_in_date' => $checkInDate,
                    'check_out_date' => $checkOutDate,
                    'total_price' => $faker->randomFloat(2, 50000, 5000900),
                    'paid_amount' => $faker->randomFloat(2, 0, 300),
                    'status' => BookingStatus::CHECKED_OUT,
                    'created_at' => $faker->dateTimeBetween($order->created_at, now()),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
