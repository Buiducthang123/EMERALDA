<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        $checkInDate = $this->faker->dateTimeBetween($startOfLastMonth, $endOfLastMonth);
        $checkOutDate = $this->faker->dateTimeBetween($checkInDate, '+7 days');

        return [
            'order_id' => null, // Sẽ được gán trong Seeder
            'user_id' => null,  // Sẽ được gán trong Seeder
            'room_id' => null,  // Sẽ được gán trong Seeder
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
            'total_price' => $this->faker->randomFloat(2, 50, 500),
            'paid_amount' => $this->faker->randomFloat(2, 0, 300),
            'status' => BookingStatus::CHECKED_OUT,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
