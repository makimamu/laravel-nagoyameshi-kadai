<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;


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
});

// 認証関連のルートを読み込み
require __DIR__ . '/auth.php';

// 管理者ホームページ
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
    });

     //Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
   // Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ユーザー管理ルート
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/dashboard', function () {

        return view('admin.dashboard'); // 管理者ホーム画面のビューを指定
    })->name('admin.dashboard');

Route::post('/logout', function () {
    Auth::logout(); // ログアウト処理
    return redirect('/login'); // ログイン画面へリダイレクト
})->name('logout');

    //Route::middleware('can:admin')->group(function () {
       // Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        //Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
    });
//});




// プロフィール関連ルート
//Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    //Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
//});
    
    // ユーザー管理ルート
    
//Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:admin'])->group(function () {
    //Route::get('users', [UserController::class, 'index'])->name('users.index');
    //Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
//});

// 管理者ログイン関連ルート
//Route::prefix('admin')->name('admin.')->group(function () {
    //Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    //Route::post('login', [LoginController::class, 'login']);
    //Route::post('logout', [LoginController::class, 'logout'])->name('logout');
//});

//Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    //Route::get('/dashboard', function () {
        //return view('admin.dashboard'); // 管理者ホーム画面のビューを指定
    //})->name('admin.dashboard');
//});