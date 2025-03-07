
<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ProfileController;

Route::middleware('guest:admin')->group(function () {
  // ログイン画面を表示するルート
  Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login');
  // ログイン処理を行うルート
  Route::post('/admin/login', [AuthenticatedSessionController::class, 'store']);
  //ログアウト
  Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
});

Route::middleware('auth:admin')->group(function () {
  // 管理者ダッシュボードにリダイレクトする例
  Route::get('/admin/dashboard', function () {
    return 'Admin Dashboard';
  })->name('admin.dashboard');
});
