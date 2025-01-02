<?php

namespace Tests\Feature\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** 未ログインのユーザーは会員一覧ページにアクセスできない */
    public function test_guest_cannot_access_user_index()
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('login')); // ログイン画面にリダイレクト
    }

    /** ログイン済みの一般ユーザーは会員一覧ページにアクセスできない */
    public function test_non_admin_user_cannot_access_user_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.index'));
        $response->assertForbidden(); // 権限不足で403
    }

    /** ログイン済みの管理者は会員一覧ページにアクセスできる */
    public function test_admin_can_access_user_index()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertOk(); // 200 OK
    }

    /** 未ログインのユーザーは会員詳細ページにアクセスできない */
    public function test_guest_cannot_access_user_show()
    {
        $user = User::factory()->create();

        $response = $this->get(route('admin.users.show', $user));
        $response->assertRedirect(route('login')); // ログイン画面にリダイレクト
    }

    /** ログイン済みの一般ユーザーは会員詳細ページにアクセスできない */
    public function test_non_admin_user_cannot_access_user_show()
    {
        $user = User::factory()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.show', $targetUser));
        $response->assertForbidden(); // 権限不足で403
    }

    /** ログイン済みの管理者は会員詳細ページにアクセスできる */
    public function test_admin_can_access_user_show()
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.users.show', $targetUser));
        $response->assertOk(); // 200 OK
    }

}
    










