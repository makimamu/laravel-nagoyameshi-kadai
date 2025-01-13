<?php

namespace Tests\Feature\Admin;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_restaurant_index()
    {
        $response = $this->get(route('admin.restaurants.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_restaurant_index()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->get(route('admin.restaurants.index'));
        $response->assertOk();
    }

    // 他のテストメソッドも同様の形式で作成
}
    

    /*public function test_admin_can_access_restaurant_index()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('admin.restaurants.index'));

        $response->assertStatus(200);
        $response->assertOk();

    }

    public function test_non_admin_cannot_access_restaurant_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.index'));

        $response->assertStatus(403);  // Forbidden
    }
    


    // 他のテストメソッドも同様の形式で作成
}*/
