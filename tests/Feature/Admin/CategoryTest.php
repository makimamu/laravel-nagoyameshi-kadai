<?php
namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    // テスト用の管理者ユーザーを作成するヘルパー
    protected function adminUser()
    {
        return Admin::factory()->create();
    }

    // 未ログインのユーザーはカテゴリ一覧にアクセスできない
    public function test_unauthenticated_user_cannot_access_category_index()
    {
        $response = $this->get(route('admin.categories.index'));

        $response->assertRedirect(route('login')); // ログインページにリダイレクトされることを確認
    }

    // 一般ユーザーは管理者側のカテゴリ一覧ページにアクセスできない
    public function test_authenticated_user_cannot_access_category_index()
    {
        $user = User::factory()->create(); // 一般ユーザー
        $response = $this->actingAs($user)->get(route('admin.categories.index'));

        $response->assertForbidden(); // アクセス禁止
    }

    // 管理者はカテゴリ一覧ページにアクセスできる
    public function test_admin_user_can_access_category_index()
    {
        $admin = $this->adminUser(); // 管理者
        $response = $this->actingAs($admin)->get(route('admin.categories.index'));

        $response->assertOk(); // 正常にアクセスできることを確認
    }

    // カテゴリの登録ができる
    public function test_admin_user_can_create_category()
    {
        $admin = $this->adminUser();
        $data = Category::factory()->make()->toArray();

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', $data); // カテゴリがデータベースに保存されていることを確認
    }

    // カテゴリの更新ができる
    public function test_admin_user_can_update_category()
    {
        $admin = $this->adminUser();
        $category = Category::factory()->create();
        $newData = ['name' => '更新されたカテゴリ名'];

        $response = $this->actingAs($admin)->patch(route('admin.categories.update', $category), $newData);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', $newData); // 更新されたデータがデータベースに保存されていることを確認
    }

    // カテゴリの削除ができる
    public function test_admin_user_can_delete_category()
    {
        $admin = $this->adminUser();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDeleted($category); // カテゴリが削除されていることを確認
    }
}