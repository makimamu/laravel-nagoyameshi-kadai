<?php

namespace Tests\Feature\Admin;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;

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

    public function test_admin_can_store_restaurant_with_categories()
{
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    // カテゴリを3つ作成
    $categories = Category::factory()->count(3)->create();
    $category_ids = $categories->pluck('id')->toArray();

    $restaurant_data = Restaurant::factory()->make()->toArray();
    $restaurant_data['category_ids'] = $category_ids;

    $response = $this->post(route('admin.restaurants.store'), $restaurant_data);

    $response->assertRedirect(route('admin.restaurants.index'));
    $this->assertDatabaseHas('restaurants', ['name' => $restaurant_data['name']]);

    unset($restaurant_data['category_ids']);
    foreach ($category_ids as $category_id) {
        $this->assertDatabaseHas('category_restaurant', [
            'category_id' => $category_id,
        ]);
    }
}
    public function test_admin_can_update_restaurant_with_categories()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);
    
        $restaurant = Restaurant::factory()->create();
        $categories = Category::factory()->count(3)->create();
        $category_ids = $categories->pluck('id')->toArray();
    
        $new_restaurant_data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'lowest_price' => 500,
            'highest_price' => 2000,
            'postal_code' => '1234567',
            'address' => 'Updated Address',
            'opening_time' => '09:00',
            'closing_time' => '22:00',
            'seating_capacity' => 50,
            'category_ids' => $category_ids,
        ];
    
        $response = $this->put(route('admin.restaurants.update', $restaurant->id), $new_restaurant_data);
    
        $response->assertRedirect(route('admin.restaurants.index'));
        $this->assertDatabaseHas('restaurants', ['name' => 'Updated Name']);
    
        unset($new_restaurant_data['category_ids']);
        foreach ($category_ids as $category_id) {
            $this->assertDatabaseHas('category_restaurant', [
                'category_id' => $category_id,
            ]);
        }
    }

    
}
    


    // 他のテストメソッドも同様の形式で作成

    

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
