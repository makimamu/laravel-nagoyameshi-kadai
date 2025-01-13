<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
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
    $user２= new User();
    $user２->name = "花子";
    $user２->kana = "ハナコ";
    $user２->email = 'hanako@example.com';
    $user２->email_verified_at = Carbon::now();
    $user２->password = Hash::make('password');
    $user２->postal_code = "1111111";
    $user２->address = "大阪府";
    $user２->phone_number = "111-1111-1111";
    $user２->save();

$user３ = new User();
    $user３->name = "会員レビュー";
    $user３->kana = "カイインレビュー";
    $user３->email = 'user@example.com';
    $user３->email_verified_at = Carbon::now();
    $user３->password = Hash::make('nagoyameshi');
    $user３->postal_code = "0000000";
    $user３->address = "東京都";
    $user３->phone_number = "000-0000-0000";
    $user３->save();

    /**
     * Run the database seeds.
     */

    }
}

