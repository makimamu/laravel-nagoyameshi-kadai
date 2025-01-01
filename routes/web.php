<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;


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

Route::get('/', function () {
    return view('welcome');
});


require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
        Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
    });
Route::middleware(['auth'])->post('/profile', [ProfileController::class, 'update'])->name('profile.update');


Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
// プロフィール編集用ルート
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

//ログイン
//Route::prefix('admin')->name('admin.')->group(function () {
    //Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    //Route::post('login', [LoginController::class, 'login']);
    //Route::post('logout', [LoginController::class, 'logout'])->name('logout');
//});