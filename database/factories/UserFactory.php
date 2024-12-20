<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use APP\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\User::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'kana' => fake()->name(),
            'name' => fake()->name(),//氏名
            'kana' => fake()->kanaName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'postal_code' => fake()->postcode(),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'is_admin' => false, // 一般ユーザー
        ];
    }


        public function admin() // 管理者用の状態
        {
            return $this->state(function (array $attributes) {
                return [
                    'is_admin' => true,//管理者
                ];
            });
        }
    }
