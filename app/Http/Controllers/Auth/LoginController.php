<?php

namespace App\Http\Controllers;  // 名前空間の追加

use Illuminate\Http\Request;   // Request クラスをインポート
use Illuminate\Support\Facades\Auth;  // Auth クラスをインポート

class LoginController extends Controller
{
    // ログインメソッド
    public function login(Request $request)
    { 
        $credentials= $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

        // 入力されたメールアドレスとパスワードを取得
        $credentials = $request->only('email', 'password');

        // 認証を試みる
        if (Auth::attempt($credentials)) {
            // 認証成功、意図されたページへリダイレクト
            return redirect()->intended('dashboard'); // 認証後のリダイレクト先を確認
        }

        // 認証失敗
        return back()->withErrors([
            'email' => __('auth.failed'),  // エラーメッセージ
        ]);
    