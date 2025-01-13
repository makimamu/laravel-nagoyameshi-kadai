<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        // 10件のレストランデータを作成
        Restaurant::factory()->count(10)->create();
    }
}