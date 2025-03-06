<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegularHolidaySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['day' => 'Monday', 'day_index' => 1],
            ['day' => 'Tuesday', 'day_index' => 2],
            ['day' => 'Wednesday', 'day_index' => 3],
            ['day' => 'Thursday', 'day_index' => 4],
            ['day' => 'Friday', 'day_index' => 5],
            ['day' => 'Saturday', 'day_index' => 6],
            ['day' => 'Sunday', 'day_index' => 7],
            ['day' => 'Irregular', 'day_index' => null], // 不定休
        ];

        DB::table('regular_holidays')->insert($data);
    }
}