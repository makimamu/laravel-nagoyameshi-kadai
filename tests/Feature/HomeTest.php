<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 未ログインのユーザーは会員側のトップページにアクセスできる()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function ログイン済みの一般ユーザーは会員側のトップページにアクセスできる()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function ログイン済みの管理者は会員側のトップページにアクセスできない()
    {
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get('/');
        $response->assertRedirect('/admin/dashboard'); // 管理者は管理画面へリダイレクトされる想定
    }
}
