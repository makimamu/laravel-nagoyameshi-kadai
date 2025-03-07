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

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }
    public function test_admins_can_authenticate_using_the_login_screen(): void
    {
        // 管理者の作成
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'nagoyameshi',
        ]);
        
    // ログイン試行
    $response = $this->post(route('admin.login'), [
        'email' => $admin->email,
        'password' => 'nagoyameshi',
    ]);
    // ログインが成功したか確認
    $this->assertAuthenticatedAs($admin, 'admin');  
    $response->assertRedirect(RouteServiceProvider::ADMIN_HOME);  // 管理者のホームにリダイレクトされることを確認
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
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $this->actingAs($admin, 'admin');

            // セッションに CSRF トークンをセット
    $token = csrf_token();
    session(['_token' => $token]);

    // CSRF トークンを含めた状態で POST リクエストを送信
    $response = $this->post('/admin/logout', ['_token' => $token]);

    // 管理者ガードで認証されていないことを確認
    $this->assertGuest('admin');
    $response->assertRedirect('/');
    }
}