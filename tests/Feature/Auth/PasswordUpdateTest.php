<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function password_can_be_updated()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($user);

        $response = $this->put('/user/password', [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    /** @test */
    public function password_update_requires_correct_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        // 誤った current_password を送信
        $response = $this->actingAs($user)->post(route('password.update'),[
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        //エラーメッセージがセッションにセットされていることを確認
        $response->assertSessionHasErrors('current_password');
        // ユーザーのパスワードが変更されていないことを確認
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));

    }
}