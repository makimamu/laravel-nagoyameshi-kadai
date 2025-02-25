<?php

namespace Tests\Feature\Feature\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Admin;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 未ログインのユーザーは管理者側のカテゴリ一覧ページにアクセスできない()
    {
        $response = $this->get('/admin/categories');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function ログイン済みの一般ユーザーは管理者側のカテゴリ一覧ページにアクセスできない()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/admin/categories');
        $response->assertStatus(403);
    }

    /** @test */
    public function ログイン済みの管理者は管理者側のカテゴリ一覧ページにアクセスできる()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $response = $this->get('/admin/categories');
        $response->assertStatus(200);
    }

    /** @test */
    public function 未ログインのユーザーはカテゴリを登録できない()
    {
        $response = $this->post('/admin/categories', ['name' => '新しいカテゴリ']);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function ログイン済みの一般ユーザーはカテゴリを登録できない()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/admin/categories', ['name' => '新しいカテゴリ']);
        $response->assertStatus(403);
    }

    /** @test */
    public function ログイン済みの管理者はカテゴリを登録できる()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $response = $this->post('/admin/categories', ['name' => '新しいカテゴリ']);
        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => '新しいカテゴリ']);
    }

    /** @test */
    public function 未ログインのユーザーはカテゴリを更新できない()
    {
        $category = Category::factory()->create();
        $response = $this->put("/admin/categories/{$category->id}", ['name' => '更新されたカテゴリ']);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function ログイン済みの一般ユーザーはカテゴリを更新できない()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $response = $this->put("/admin/categories/{$category->id}", ['name' => '更新されたカテゴリ']);
        $response->assertStatus(403);
    }

    /** @test */
    public function ログイン済みの管理者はカテゴリを更新できる()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $category = Category::factory()->create();
        $response = $this->put("/admin/categories/{$category->id}", ['name' => '更新されたカテゴリ']);
        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => '更新されたカテゴリ']);
    }

    /** @test */
    public function 未ログインのユーザーはカテゴリを削除できない()
    {
        $category = Category::factory()->create();
        $response = $this->delete("/admin/categories/{$category->id}");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function ログイン済みの一般ユーザーはカテゴリを削除できない()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $response = $this->delete("/admin/categories/{$category->id}");
        $response->assertStatus(403);
    }

    /** @test */
    public function ログイン済みの管理者はカテゴリを削除できる()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $category = Category::factory()->create();
        $response = $this->delete("/admin/categories/{$category->id}");
        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}