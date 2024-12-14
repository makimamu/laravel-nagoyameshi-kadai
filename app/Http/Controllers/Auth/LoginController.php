<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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