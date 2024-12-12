<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InvoicesFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'booking_id' => Booking::inRandomOrder()->first()->id,
            'services' => json_encode([
                ['name' => 'Dịch vụ ăn uống', 'price' => $this->faker->randomFloat(2, 10, 50)],
                ['name' => 'Dịch vụ spa', 'price' => $this->faker->randomFloat(2, 20, 100)],
            ]),
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
            'type' => $this->faker->randomElement(\App\Enums\InvoiceType::getValues()),
            'status' => $this->faker->randomElement(\App\Enums\InvoiceStatus::getValues()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
