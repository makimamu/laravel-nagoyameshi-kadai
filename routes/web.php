<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Auth\MemberHomeController;



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

// 会員認証ルート
require __DIR__ . '/auth.php';

// 管理者用ルート
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {

        // 管理者ホームページ
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
            Route::resource('restaurants', RestaurantController::class);

            // カテゴリー管理
            Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
            // 上記のカテゴリ管理のルートを追加
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });
        //会社概要
        Route::get('company', [CompanyController::class, 'index'])->name('company.index');
        Route::get('company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('company/{company}', [CompanyController::class, 'update'])->name('company.update');

        // 利用規約
        Route::get('terms', [TermController::class, 'index'])->name('terms.index');
        Route::get('terms/{term}/edit', [TermController::class, 'edit'])->name('terms.edit');
        Route::put('terms/{term}', [TermController::class, 'update'])->name('terms.update');
    });

// 管理者認証ルート（ゲスト管理者用）
// ============================================
Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// 管理者ログアウト
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:admin')
    ->name('logout');

// ============================================
// 会員用ルート（ゲストユーザー用）
// ============================================
//Route::middleware('guest')->group(function () {
    //Route::get('/', [MemberHomeController::class, 'index'])->name('home');
//});

// ============================================
// 会員用ルート（認証済み & メール認証済みユーザー）
// ============================================
//Route::middleware(['auth', 'verified'])
    //->prefix('user')
    //->name('user.')
    //->group(function () {
        //Route::get('/', [MemberUserController::class, 'index'])->name('index');
        //Route::get('edit/{user}', [MemberUserController::class, 'edit'])->name('edit');
       // Route::put('update/{user}', [MemberUserController::class, 'update'])->name('update');
    //});
