<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    
    public function handle(Request $request, Closure $next)
    {
        // ユーザーがログインしていて、かつ is_admin フィールドが true の場合
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // 管理者でない場合は 403 Forbidden を返す
        abort(403, 'Unauthorized action.');
    }
}