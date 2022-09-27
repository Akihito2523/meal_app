<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// 「/」にアクセスした場合indexアクションを呼び出す
Route::get('/', [PostController::class, 'index'])
    ->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// 認証していなければアクセスできないように制御
Route::resource('meals', PostController::class)
    ->only(['store', 'create', 'update', 'destroy', 'edit'])
    ->middleware('auth');

//認証していなくてもアクセスできる
Route::resource('meals', PostController::class)
    ->only(['index', 'show']);

require __DIR__ . '/auth.php';
