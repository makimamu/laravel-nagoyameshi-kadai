<?php

namespace Tests\Feature\Feature\Admin;

use App\Models\User; // 追加
use App\Models\Term;  // 追加
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TermTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

public function test_terms_index_page_access()
{
    $response = $this->get('/admin/terms');
    $response->assertRedirect('/login');

    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/admin/terms');
    $response->assertForbidden();

    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);
    $response = $this->get('/admin/terms');
    $response->assertStatus(200);
}
public function test_update_terms()
{
    $term = Term::factory()->create();

    $response = $this->put("/admin/terms/{$term->id}", []);
    $response->assertRedirect('/login');

    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->put("/admin/terms/{$term->id}", []);
    $response->assertForbidden();

    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);
    $response = $this->put("/admin/terms/{$term->id}", ['content' => '新しい利用規約']);
    $response->assertRedirect('/admin/terms');
    $this->assertDatabaseHas('terms', ['content' => '新しい利用規約']);
}
}
