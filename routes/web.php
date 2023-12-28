<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::post('/login',[LoginController::class, 'login']);
Route::post('/logout', [LoginController::class,'logout'])->name('logout');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register',[RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('/register',[RegisterController::class,'register']);


Route::middleware('auth')->group(function(){

Route::get('/home',[ProductController::class,'index'])->name('home');

// 商品情報画面のルーティング
Route::get('/index',[ProductController::class, 'index'])->name('index');

// 新規登録画面
Route::get('/create', [ProductController::class, 'create'])->name('create');

// 登録処理
Route::post('/store', [ProductController::class, 'store'])->name('store');

// 検索機能
Route::get('/search', [ProductController::class, 'search'])->name('search');

//詳細画面
Route::get('/detail/{id}', [ProductController::class, 'showDetail'])->name('detail');

// 編集画面
Route::get('/details/edit/{id}', [ProductController::class, 'showEdit'])->name('edit');

//編集画面更新
Route::put('/edit/update{id}', [ProductController::class, 'update'])->name('update')->middleware('web');

// 削除
Route::delete('/index/delete/{id}', [ProductController::class, 'delete'])->name('delete');

});