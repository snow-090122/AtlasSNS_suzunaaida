<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

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


require __DIR__ . '/auth.php';
Route::group(['middleware' => 'auth'], function () {
  Route::get('/top', [PostsController::class, 'idex']);
  Route::post('/post', [PostsController::class, 'postCreate']);
  Route::post('/post/edit', [PostsController::class, 'postEdit']);
  Route::get('/delete/{id}', [PostsController::class, 'delete']);

  Route::get('/profile/{id}', [UsersController::class, 'profile']);
  Route::post('/profile/edit', [UsersController::class, 'profileEdit'])->name('profile.edit');

  Route::get('/search', [UsersController::class, 'search']);
  Route::post('/search', [UsersController::class, 'search']);

  Route::post('/follow', [FollowsController::class, 'follow']);
  Route::post('/remove', [FollowsController::class, 'remove']);

  Route::get('/follow-list', [FollowsController::class, 'followList']);
  Route::get('/follower-list', [FollowsController::class, 'followerList']);

  Route::get('/logout', [UsersController::class, 'logout']);
});

//ログアウト中
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'register']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/added', [RegisterController::class, 'added']);
Route::post('/added', [RegisterController::class, 'added']);
