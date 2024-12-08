<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 認証後のリダイレクト処理をここで実行
        return $this->authenticated($request, Auth::user());
    }

    /**
     * Handle after successful authentication.
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        if ($user->is_admin) {
            return redirect(RouteServiceProvider::ADMIN_HOME); // 管理者の場合
        }

        return redirect(RouteServiceProvider::HOME); // 一般ユーザーの場合
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}