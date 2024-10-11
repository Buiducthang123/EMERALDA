<?php

namespace Database\Seeders;

use App\Enums\AccountStatus;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        for ($i = 0; $i < 11; $i++) {
            User::create([
                'name' => $faker->name,
                'phone_number' => $faker->unique()->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'avatar' => 'https://gcs.tripi.vn/public-tripi/tripi-feed/img/474114AbO/hinh-anh-jack-dep-trai-cute-dang-yeu-nhat-2021_013741456.jpg',
                'address' => $faker->optional()->address,
                'role' => UserRole::GUEST,
                'status' => AccountStatus::ACTIVE,
                'birthday' => $faker->optional()->date,
                'email_verified_at' => $faker->optional()->dateTime,
                'password' => Hash::make(value: '123456'), // Default password
            ]);
        }

    }
}
