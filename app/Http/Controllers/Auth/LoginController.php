<?php
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // 認証成功
        return redirect()->intended('dashboard');
    }

    // 認証失敗
    return back()->withErrors([
        'email' => __('auth.failed'),
    ]);
}