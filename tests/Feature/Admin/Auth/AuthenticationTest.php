<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    
    use RefreshDatabase;

    // setUpメソッドでテスト前の準備を行う
    public function setUp(): void
    {
        parent::setUp();

        // 管理者ユーザーを作成
        $this->admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('nagoyameshi'), // 適切なパスワードを設定
        ]);
    }

    public function test_login_screen_can_be_rendered(): void
    {
    $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }
    public function test_admins_can_authenticate_using_the_login_screen(): void
    {
        $response = $this->post('/admin/login', [
            'email' => $this->admin->email,
            'password' => 'nagoyameshi', // 作成したパスワード
        ]);
        
        $this->assertTrue(Auth::guard('admin')->check());
        $response->assertRedirect(RouteServiceProvider::ADMIN_HOME);
    }
    public function test_admins_can_not_authenticate_with_invalid_password(): void
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }

    public function test_admins_can_logout(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}

