<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // 入力値のバリデーション
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    // 現在のパスワードが正しいか確認
                    if (!Hash::check($value, $request->user()->password)) {
                        $fail(__('The current password is incorrect.'));
                    }
                },
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // パスワードを更新
        $request->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        // 成功後のリダイレクト
        return back()->with('status', __('Password updated successfully.'));
    }
}