<?php
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

public function login(Request $request)
{
    // 入力データのバリデーション
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // 認証成功
        return redirect()->intended(config('app.default_redirect', 'dashboard'));
    }

    // 認証失敗（スロットリングを追加する場合は下記を活用）
    return back()->withErrors([
        'email' => __('auth.failed'),
    ])->withInput(); // フォームの値を保持
}