<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                'restaurant_id' => Str::uuid()->toString(),
                'name' => 'Buko Seaside Bar and Restaurant',
                'location' => 'City Center',
                'operating_hours' => '10:00 AM - 10:00 PM',
                'image' => 'http://127.0.0.1:8000/storage/restaurants/buko_seaside.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => Str::uuid()->toString(),
                'name' => 'Tides at Shangrila Mactan',
                'location' => 'Beachside',
                'operating_hours' => '11:00 AM - 11:00 PM',
                'image' => 'http://127.0.0.1:8000/storage/restaurants/tides_shangrila.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'restaurant_id' => Str::uuid()->toString(),
                'name' => 'Vikings Luxury Buffet',
                'location' => 'Downtown',
                'operating_hours' => '12:00 PM - 9:00 PM',
                'image' => 'http://127.0.0.1:8000/storage/restaurants/vikings_buffet.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('restaurants')->insert($restaurants);
    }
}