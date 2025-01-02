<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login()
    {
        // ログイン処理
    }

    public function logout()
    {
        // ログアウト処理
    }
    //protected function authenticated(Request $request, $user)
//{
    //return redirect('/dashboard'); // ログイン後のリダイレクト先
//}
}