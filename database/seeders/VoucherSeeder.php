<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('vouchers')->insert([
                'name' => $faker->word,
                'main_image' => $faker->imageUrl(640, 480, 'vouchers', true),
                'description' => $faker->sentence,
                'quantity' => $faker->numberBetween(1, 1000),
                'code' => $faker->unique()->bothify('VOUCHER-####'),
                'discount_amount' => $faker->randomFloat(2, 5, 100),
                'valid_from' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
                'valid_until' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
