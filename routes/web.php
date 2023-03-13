<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [PostController::class, 'index'])->name('posts.index')->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/posts/{category}', [PostController::class, 'show'])->name('posts.show')->middleware('auth');

Route::post('/likes', [LikeController::class, 'like'])->name('likes.like')->middleware('auth');

Route::post('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');