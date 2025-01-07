<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_users_cannot_access_admin_user_list_page()
    {
        $response = $this->get(route('admin.users.index')); // 会員一覧ページへのルート
        $response->assertRedirect(route('admin.login')); // 未ログインのユーザーはログインページへリダイレクトされる
    }

    /** @test */
    public function regular_users_cannot_access_admin_user_list_page()
    {
        $user = User::factory()->create(); // 一般ユーザーを作成

        $response = $this->actingAs($user)->get(route('admin.users.index'));
        $response->assertForbidden(); // アクセスが禁止されることを確認
    }

    /** @test */
    public function admin_users_can_access_admin_user_list_page()
    {
        $admin = Admin::factory()->create(); // 管理者を作成

        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.index'));
        $response->assertOk(); // アクセス成功を確認
    }

    /** @test */
    public function guest_users_cannot_access_admin_user_detail_page()
    {
        $response = $this->get(route('admin.users.show', 1)); // 会員詳細ページへのルート
        $response->assertRedirect(route('admin.login')); // 未ログインのユーザーはログインページへリダイレクトされる
    }

    /** @test */
    public function regular_users_cannot_access_admin_user_detail_page()
    {
        $user = User::factory()->create(); // 一般ユーザーを作成

        $response = $this->actingAs($user)->get(route('admin.users.show', 1));
        $response->assertForbidden(); // アクセスが禁止されることを確認
    }

    /** @test */
    public function admin_users_can_access_admin_user_detail_page()
    {
        $admin = Admin::factory()->create(); // 管理者を作成
        $user = User::factory()->create(); // 会員データを作成

        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.show', $user->id));
        $response->assertOk(); // アクセス成功を確認
    }
}

/*namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_user_list_page()
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('login'));
    }
    public function test_normal_user_cannot_access_user_list_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.users.index'));
        $response->assertForbidden();
    }
    public function test_admin_can_access_user_list_page()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertOk();
        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_user_detail_page()
    {
        $user = User::factory()->create();
        $response = $this->get(route('admin.users.show', $user));
        $response->assertRedirect(route('login'));
    }

    public function test_normal_user_cannot_access_user_detail_page()
    {
        $user = User::factory()->create();
        $normalUser = User::factory()->create();
        $response = $this->actingAs($normalUser)->get(route('admin.users.show', $user));
        $response->assertForbidden();
    }

    public function test_admin_can_access_user_detail_page()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $response = $this->actingAs($admin)->get(route('admin.users.show', $user));
        $response->assertOk();
    }
}*/