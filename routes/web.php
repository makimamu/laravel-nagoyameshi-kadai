<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__ . '/auth.php';

// 管理者向けのルート
//Route::prefix('admin')->name('admin.')->group(function () {
    // 管理者ログイン関連ルート
   // Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
   // Route::post('login', [LoginController::class, 'login']);
    //Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // 認証が必要なルート
    // Route::middleware('auth:admin')->group(function () {
    //     Route::get('home', [HomeController::class, 'index'])->name('home');
        
    //     // 会員管理機能
    //     Route::get('/users', [UserController::class, 'index'])->name('users.index');
    //     Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

    //     // 店舗管理機能
    //     Route::resource('restaurants', RestaurantController::class);
    // });
//});

// 一般ユーザー向けのルート
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});













/*use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::resource('restaurants', RestaurantController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});*/