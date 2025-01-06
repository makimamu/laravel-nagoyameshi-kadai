<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    // ログインフォームを表示
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // ログイン処理（詳細は実装に依存）
    public function login()
    {
        // ログイン処理
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        // 管理者用認証ガードを使ってログアウト
        Auth::guard('admin')->logout();
        
        // セッションを無効化し、トークンを再生成
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // ログイン画面にリダイレクト
        return redirect()->route('admin.login');
    }

    // ログイン後のリダイレクト先
    protected function redirectTo()
{
    return '/admin/users';// ダッシュボードなどのリダイレクト先
} 
    }
