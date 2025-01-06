<?php
namespace Tests\Feature\Admin;

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
}
