<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use APP\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'name' => $this->faker->name(), // Fakerを使ってランダムな名前を生成
            'kana' => $this->faker->kanaName(),
            'email' => $this->faker->unique()->safeEmail(), // Fakerでユニークなメールアドレスを生成
            'password' => Hash::make('password'), // ハッシュ化したデフォルトパスワード
            'is_admin' => true, // 管理者フラグ（true固定）
        ];
    }
}