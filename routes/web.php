<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;


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
// 
Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
});

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
// 管理者用ルート
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'show']);
});

// 管理者用ルーティング設定
Route::prefix('admin')->name('admin.')->group(function () {
    // 会員一覧ページ
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    // 会員詳細ページ
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
});

    // 会員詳細ページのルート
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');