<?php

namespace Database\Factories;

use App\Models\RegularHoliday;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegularHolidayFactory extends Factory
{
    protected $model = RegularHoliday::class;

    public function definition()
    {
        return [
            'day' => $this->faker->dayOfWeek(),
            // 'day_index' は NULL を許容するため、ここでは指定しません
        ];
    }
}