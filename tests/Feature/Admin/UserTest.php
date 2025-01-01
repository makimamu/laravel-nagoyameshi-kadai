<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; 

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_guest_cannot_access_user_list()
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_access_user_list()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin, 'admin');

        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(200);
    }
    
}
