<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\CategoryController;

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

// ウェルカムページ
Route::get('/', function () {
    return view('welcome');
});

// 認証用ルート
require __DIR__ . '/auth.php';

// 管理者用ルート
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {

    // ホームページ
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // ユーザー管理
    Route::resource('users', UserController::class)->only(['index', 'show']);

    // 店舗管理（admin 認証 + is_admin ミドルウェアを適用）
    Route::middleware(['is_admin'])->group(function () {
        Route::get('restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
        Route::get('restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
        Route::post('restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
        Route::get('restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');
        Route::get('restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
        Route::put('restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
        Route::delete('restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
    });
// カテゴリー管理
Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
// 上記のカテゴリ管理のルートを追加
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// 管理者認証ルート
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:admin')
    ->name('logout');