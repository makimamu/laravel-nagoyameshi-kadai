<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $user = new User();
            $user->name = "太郎";
            $user->kana = "タロウ";
            $user->email = 'tarou@example.com';
            $user->email_verified_at = Carbon::now();
            $user->password = Hash::make('password');
            $user->postal_code = "0000000";
            $user->address = "東京都";
            $user->phone_number = "000-0000-0000";
            $user->save();

            // 2人目
            $user2 = new User();
            $user2->name = "花子";
            $user2->kana = "ハナコ";
            $user2->email = 'hanako@example.com';
            $user2->email_verified_at = Carbon::now();
            $user2->password = Hash::make('password');
            $user2->postal_code = "1111111";
            $user2->address = "大阪府";
            $user2->phone_number = "111-1111-1111";
            $user2->save();

            User::factory()->count(100)->create();
    }
}
