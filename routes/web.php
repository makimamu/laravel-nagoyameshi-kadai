<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// トップページ: 必要に応じて変更
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 認証関連のルートを読み込み
require __DIR__ . '/auth.php';

// プロフィール関連ルート
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// 管理者用ルート（認証が必要）
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // 管理者ホームページ
    Route::get('home', [HomeController::class, 'index'])->name('home');
    
    // ユーザー管理ルート
    Route::get('users', [UserController::class, 'index'])->name('users.index'); // 一覧ページ
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show'); // 詳細ページ
});

// 管理者ログイン関連ルート
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});