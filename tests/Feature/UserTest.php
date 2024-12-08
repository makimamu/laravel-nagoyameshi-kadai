<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 未ログインのユーザーは管理者側の会員一覧ページにアクセスできない
     */
    public function test_guest_cannot_access_user_index()
    {
        $response = $this->get('/admin/users'); // 適切なルートに変更
        $response->assertRedirect('/login'); // ログインページにリダイレクトされる
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会員一覧ページにアクセスできない
     */
    public function test_non_admin_user_cannot_access_user_index()
    {
        $user = User::factory()->create(); // 一般ユーザー作成
        $response = $this->actingAs($user)->get('/admin/users');
        $response->assertStatus(403); // 権限不足のステータスを確認
    }

    /**
     * ログイン済みの管理者は管理者側の会員一覧ページにアクセスできる
     */
    public function test_admin_can_access_user_index()
    {
        $admin = User::factory()->create(['is_admin' => true]); // 管理者ユーザー作成
        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200); // 正常アクセスを確認
    }

    /**
     * 未ログインのユーザーは管理者側の会員詳細ページにアクセスできない
     */
    public function test_guest_cannot_access_user_show()
    {
        $response = $this->get('/admin/users/1'); // 適切なIDに変更
        $response->assertRedirect('/login'); // ログインページにリダイレクト
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会員詳細ページにアクセスできない
     */
    public function test_non_admin_user_cannot_access_user_show()
    {
        $user = User::factory()->create(); // 一般ユーザー作成
        $response = $this->actingAs($user)->get('/admin/users/1');
        $response->assertStatus(403); // 権限不足
    }

    /**
     * ログイン済みの管理者は管理者側の会員詳細ページにアクセスできる
     */
    public function test_admin_can_access_user_show()
    {
        $admin = User::factory()->create(['is_admin' => true]); // 管理者ユーザー作成
        $response = $this->actingAs($admin)->get('/admin/users/1');
        $response->assertStatus(200); // 正常アクセス
    }
}










