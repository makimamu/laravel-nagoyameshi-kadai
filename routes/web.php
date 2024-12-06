<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RestaurantController;

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

    // 店舗管理
    Route::resource('restaurants', RestaurantController::class);
});

    // またはリソースルートを明示的に書く場合（以下の記述は上記と等価）
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function() {
    Route::get('restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
    Route::get('restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
    Route::get('restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');
    Route::get('restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');

});

// 管理者認証ルート
Route::middleware('guest')->group(function () {
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

;
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
->middleware('auth:admin')
->name('logout');
});