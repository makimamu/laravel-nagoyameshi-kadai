<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_restaurant_index()
{
    // 管理者ユーザーを作成
    $admin = User::factory()->create([
        'is_admin' => true,
    ]);

    // 管理者ガードで認証
    $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.index'));

    // ステータスコード200を確認
    $response->assertStatus(200);
}

public function test_non_admin_cannot_access_restaurant_index()
{
    // 非管理者ユーザーを作成
    $user = User::factory()->create();

    // 非管理者でレストラン一覧ページにアクセス
    $response = $this->actingAs($user)->get(route('admin.restaurants.index'));

    // リダイレクトが発生することを確認
    $response->assertStatus(302);  // リダイレクトが発生
    $response->assertRedirect('/login');  // ログインページにリダイレクトされることを確認
}

}

    // 他のアクションのテストも同様に記述します
