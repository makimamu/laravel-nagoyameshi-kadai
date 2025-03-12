<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController as UserHomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\TermController;


// 認証関連のルートを読み込み
require __DIR__ . '/auth.php';

// 会員側のトップページ（管理者としてログインしていない場合のみアクセス可能）
Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/', [UserHomeController::class, 'index'])->name('home');
});

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {

    // 管理者ホーム
    Route::get('/home', [AdminHomeController::class, 'index'])->name('home');

    // ユーザー管理
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // 会員店舗管理
    Route::resource('restaurants', RestaurantController::class);

    // カテゴリ管理 (管理者のみアクセス可能)
    Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);

    // 会社概要
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::get('/edit/{company}', [CompanyController::class, 'edit'])->name('edit');
        Route::match(['post', 'patch'], '/update/{company}', [CompanyController::class, 'update'])->name('update');
    });

    // 利用規約
    Route::prefix('terms')->name('terms.')->group(function () {
        Route::get('/', [TermController::class, 'index'])->name('index');
        Route::get('/edit/{term}', [TermController::class, 'edit'])->name('edit');
        Route::match(['post', 'patch'], '/update/{term}', [TermController::class, 'update'])->name('update');
    });

});