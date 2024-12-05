<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Faker\Generator as Faker;

$factory->define(Restaurant::class, function (Faker $faker) {
    return [
        'name' => 'テスト',
        'description' => 'テスト',
        'lowest_price' => 1000,
        'highest_price' => 5000,
        'postal_code' => '0000000',
        'address' => 'テスト',
        'opening_time' => '10:00:00',
        'closing_time' => '20:00:00',
        'seating_capacity' => 50,
    ];
});