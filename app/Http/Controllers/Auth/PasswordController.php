<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // 入力バリデーション
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                // 現在のパスワードが一致しない場合
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 新しいパスワードのバリデーション
        ]);

        // パスワードの更新
        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        // パスワード更新成功後のリダイレクト
        return back()->with('status', 'password-updated');
    }
}
        //$validated = $request->validateWithBag('updatePassword', [
            //'current_password' => ['required', 'current_password'],
            //'password' => ['required', Password::defaults(), 'confirmed'],
        //]);

        //$request->user()->update([
            //'password' => Hash::make($validated['password']),
        //]);

        //return back()->with('status', 'password-updated');