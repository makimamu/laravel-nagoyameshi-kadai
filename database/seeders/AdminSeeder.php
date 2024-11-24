<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
    }

    public function run(): void
    {
        $admin = new Admin();
        $admin->email = '';
        $admin->password = Hash::make('password123');
        $admin->save();
    }
    public function run(): void
    {
        $admin = new Admin();
        $admin->name = "田中 太郎";
        $admin->email = 'makittynya@icloud.com';
        $admin->password = Hash::make('password123');
        $admin->save();
    }
}


