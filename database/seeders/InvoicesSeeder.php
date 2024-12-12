<?php

namespace Database\Seeders;

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoicesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        Booking::all()->each(function ($booking) use ($faker) {
            Invoice::create([
                'booking_id' => $booking->id,
                'services' => json_encode([
                    ['name' => 'Dịch vụ ăn uống', 'price' => $faker->randomFloat(2, 10, 50)],
                    ['name' => 'Dịch vụ spa', 'price' => $faker->randomFloat(2, 20, 100)],
                ]),
                'total_amount' => $faker->randomFloat(2, 100, 1000),
                'type' => InvoiceType::PAYMENT,
                'status' => InvoiceStatus::PAID,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
