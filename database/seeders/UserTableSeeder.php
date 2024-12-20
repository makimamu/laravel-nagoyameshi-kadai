<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    User::factory()->count(100)->create(); // ダミーデータ100件を生成
    User::factory()->create([
        'is_admin' => true,
    ]);
    }
}
