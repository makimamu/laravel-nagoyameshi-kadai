<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        // 管理者データを作成
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        
            //'is_admin' => true, // 管理者フラグを設定

        // ログインを実行
        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'nagoyameshi',
        ]);

        // ログイン成功を確認
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
            'password' => 'wrong-password', // 間違ったパスワード
        ]);

        $this->assertGuest(); // ゲスト状態を確認
    }

    public function test_admins_can_logout(): void
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        //'is_admin' => true,
        
        // ログイン状態にする
        $response = $this->actingAs($admin, 'admin')->post('/admin/logout');

        $this->assertGuest(); // ログアウト後はゲスト状態を確認
        $response->assertRedirect('/'); // リダイレクトを確認
    }
}