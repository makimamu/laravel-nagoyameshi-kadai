<?php

namespace Tests\Feature\Feature\Admin;

use App\Models\User; // 追加
use App\Models\Term;  // 追加
use App\Models\Company; // 追加
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    //indexアクション (会社概要ページ)
    public function test_index_page_access()
{
    // 未ログインのユーザーがアクセスした場合
    $response = $this->get('/admin/company');
    $response->assertRedirect('/login');

    // ログイン済みの一般ユーザーがアクセスした場合
    $user = User::factory()->create();  // 一般ユーザーの作成
    $this->actingAs($user);
    $response = $this->get('/admin/company');
    $response->assertForbidden();

    // ログイン済みの管理者がアクセスした場合
    $admin = User::factory()->create(['is_admin' => true]);  // 管理者の作成
    $this->actingAs($admin);
    $response = $this->get('/admin/company');
    $response->assertStatus(200);
}
//editアクション (会社概要編集ページ)
public function test_edit_page_access()
{
    $company = Company::factory()->create();

    // 未ログインのユーザーがアクセスした場合
    $response = $this->get("/admin/company/{$company->id}/edit");
    $response->assertRedirect('/login');

    // ログイン済みの一般ユーザーがアクセスした場合
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get("/admin/company/{$company->id}/edit");
    $response->assertForbidden();

    // ログイン済みの管理者がアクセスした場合
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);
    $response = $this->get("/admin/company/{$company->id}/edit");
    $response->assertStatus(200);
}
//updateアクション (会社概要更新機能)
public function test_update_company()
{
    $company = Company::factory()->create();

    // 未ログインのユーザーが更新しようとした場合
    $response = $this->put("/admin/company/{$company->id}", []);
    $response->assertRedirect('/login');

    // ログイン済みの一般ユーザーが更新しようとした場合
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->put("/admin/company/{$company->id}", []);
    $response->assertForbidden();

    // ログイン済みの管理者が更新できるか
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);
    $response = $this->put("/admin/company/{$company->id}", [
        'name' => '新しい会社名',
        'postal_code' => '1234567',
        'address' => '新しい住所',
        'representative' => '新しい代表者',
        'establishment_date' => '2025-03-09',
        'capital' => '1000000',
        'business' => '新しい事業内容',
        'number_of_employees' => '50'
    ]);
    $response->assertRedirect('/admin/company');
    $this->assertDatabaseHas('companies', ['name' => '新しい会社名']);
}

}
