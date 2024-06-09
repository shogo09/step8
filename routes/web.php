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

Route::post('/login',[LoginController::class, 'login']);
Route::post('/logout', [LoginController::class,'logout'])->name('logout');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register',[RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('/register',[RegisterController::class,'register']);

Route::middleware('auth')->group(function(){
    Route::controller(ProductController::class)->group(function () {
        Route::get('/home', 'home')->name('home');
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/search', 'search')->name('search');
        Route::get('/detail/{id}', 'showDetail')->name('detail');
        Route::get('/details/edit/{id}', 'showEdit')->name('edit');
        Route::put('/edit/update{id}', 'update')->name('update')->middleware('web');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
        Route::get('/cart/{id}',  'cart')->name('cart');
        Route::post('/purchase/{id}', 'purchase')->name('purchase');
    });
  });