<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;


    public function definition(): array
    {
        $user_ids = User::all()->pluck('id')->toArray();
        return [
            'room_ids' => json_encode($this->faker->randomElements([1, 2, 3, 4, 5], rand(1, 3))),
            'customer_info' => json_encode([
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'phone' => $this->faker->phoneNumber(),
            ]),
            'voucher_code' => $this->faker->optional()->regexify('[A-Z0-9]{10}'),
            'user_id' => $this->faker->randomElement($user_ids),
            'total_price' => $this->faker->randomFloat(2, 100, 1000),
            'payable_amount' => $this->faker->randomFloat(2, 50, 800),
            'prepayment_amount' => $this->faker->randomFloat(2, 0, 500),
            'status' => $this->faker->randomElement(OrderStatus::getValues()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
