<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomType::create([
            'name' => 'Phòng Premium Balcony Room',
            'slug' => 'phong-premium-balcony-room',
            'description' => 'Phòng Premium Balcony Room với diện tích 30m2, ban công riêng, giường đôi hoặc 2 giường đơn, phòng tắm riêng với vòi sen và bồn tắm.',
            'main_image' => 'https://thereedhotel.com/wp-content/uploads/2015/07/room-deluxe-3-600x400.jpg',
            'thumbnails' => [
                'https://thereedhotel.com/wp-content/uploads/2015/07/room-deluxe-3-600x400.jpg',
                'https://thereedhotel.com/wp-content/uploads/2015/07/room-deluxe-5.jpg',
                'https://thereedhotel.com/wp-content/uploads/2015/07/room-deluxe-6-copy.jpg',
            ],
            'amenities' => [],
            'features' => [],
            'max_people' => 3,
            'price' => 100000,
            'area' => 30,
        ]);

        RoomType::create([
            'name' => 'Phòng Deluxe',
            'slug' => 'phong-deluxe',
            'description' => 'Phòng Deluxe với diện tích 30m2, giường đôi hoặc 2 giường đơn, phòng tắm riêng với vòi sen và bồn tắm.',
            'main_image' => 'https://thereedhotel.com/wp-content/uploads/2015/07/room-grand-deluxe-1-600x400.jpg',
            'thumbnails' => [
                'https://thereedhotel.com/wp-content/uploads/2015/07/room-grand-deluxe-1-600x400.jpg',
                'https://thereedhotel.com/wp-content/uploads/2015/07/room-grand-deluxe-3-600x400.jpg',
                'https://thereedhotel.com/wp-content/uploads/2015/07/room-grand-deluxe-5-300x200.jpg',
            ],
            'amenities' => [],
            'features' => [],
            'max_people' => 5,
            'price' => 200000,
            'area' => 50,
        ]);

        RoomType::create([
            'name' => 'Phòng Grand VIP',
            'slug' => 'phong-grand-vip',
            'description' => 'Với diện tích 42m2, phòng Grand VIP tại The Reed Hotel là lựa chọn hoàn hảo cho kỳ nghỉ của gia đình, hoặc những Qúy khách có nhu cầu nghỉ ngơi rộng rãi hơn.
            WIFI miễn phí tốc độ cao, TV vệ tinh và các trang thiết bị điện theo chuẩn quốc tế được trang bị tại toàn bộ các phòng nghỉ của The Reed Hotel.',
            'main_image' => 'https://thereedhotel.com/wp-content/uploads/2017/02/room-jr-suite-2-600x400.jpg',
            'thumbnails' => [
                'https://thereedhotel.com/wp-content/uploads/2015/07/room-jr-suite-3-600x400.jpg',
                'https://thereedhotel.com/wp-content/uploads/2015/07/room-deluxe-6-copy.jpg',
                'https://thereedhotel.com/wp-content/uploads/2017/02/room-jr-suite-4-600x400.jpg',
            ],
            'amenities' => [],
            'features' => [],
            'max_people' => 5,
            'price' => 300000,
            'area' => 42,
        ]);
    }
}
