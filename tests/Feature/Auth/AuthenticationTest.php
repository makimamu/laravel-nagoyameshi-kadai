<?php
namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        // パスワードの設定に注意（パスワードは 'password' として作成される）
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // User::factory() によって作成されるパスワードと一致
        ]);

        // 認証されていることを確認
        $this->assertAuthenticated();

        // RouteServiceProvider::HOME の設定に合わせて修正
        $response->assertRedirect(RouteServiceProvider::HOME); // ここが /admin/home ならば修正
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password', // 間違ったパスワードを試す
        ]);

        // ゲスト状態の確認
        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        // ログアウト後、ゲスト状態であることを確認
        $this->assertGuest();

        // ログアウト後にリダイレクト先が '/' であることを確認
        $response->assertRedirect('/');
    }
}