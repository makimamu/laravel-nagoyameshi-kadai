<?php

namespace App\Http\Controllers;  // 名前空間の追加

use Illuminate\Http\Request;   // Request クラスをインポート
use Illuminate\Support\Facades\Auth;  // Auth クラスをインポート

class LoginController extends Controller
{
    // ログインメソッド
    public function login(Request $request)
    {
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
    }
}