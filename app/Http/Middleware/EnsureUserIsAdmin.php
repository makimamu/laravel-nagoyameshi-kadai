<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle($request, Closure $next)
    {
        // 管理者認証ガードをチェック
        if (!Auth::guard('admin')->check() || !Auth::user()->is_admin) {
            return redirect('/login'); // 未認証の場合はログイン画面にリダイレクト
        }

        return $next($request);
    }
}