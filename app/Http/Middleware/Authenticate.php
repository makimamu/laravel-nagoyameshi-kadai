<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)// ※このコードは後に使わない
    {
        if ($request->is('admin/*')) { //管理者向けページ (admin/*) にアクセス:
            return route('admin.login'); //未認証の場合、admin.login ルートにリダイレクトされます
            }
            
        return $request->expectsJson() ? null : route('login');
    }
}
