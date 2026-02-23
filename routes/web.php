<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get(uri: '/', action: function (): View {
    return view(view: 'welcome');
});

Route::resource(name: 'categories', controller: CategoryController::class);
Route::resource(name: 'posts', controller: PostController::class);

Route::resource('users',AuthController::class)
->except(['create','store']);
Route::get('/register',[AuthController::class,'register_form'])->name('register');
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::get('/login',[AuthController::class,'login_form'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
