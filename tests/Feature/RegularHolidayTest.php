<?php

namespace Tests\Feature;

use App\Models\RegularHoliday;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegularHolidayTest extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
/** @test */
public function 店舗に定休日を設定できる()
{
    // 定休日を3つ作成
    $holidays = RegularHoliday::factory()->count(3)->create();

    // 店舗を作成
    $restaurant = Restaurant::factory()->create();

    // 店舗に定休日を設定
    $restaurant->regularHolidays()->attach($holidays->pluck('id'));

    // 定休日が正しく設定されているか確認
    $this->assertCount(3, $restaurant->regularHolidays);
    
    }
}