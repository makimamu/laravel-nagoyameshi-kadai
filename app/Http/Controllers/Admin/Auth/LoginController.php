<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{

    // ログイン後のリダイレクト先
    //protected $redirectTo = '/admin/dashboard'; // 管理者ホーム画面のルートを指定
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login()
    {
        // ログイン処理
        return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
    }

    public function logout()
    {
        // ログアウト処理
    }

       // ログイン後のリダイレクト先
       protected $redirectTo = '/admin/dashboard'; // 管理者ホーム画面のルートを指定

}