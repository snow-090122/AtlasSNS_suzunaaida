<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use PHPUnit\Framework\RiskyTestError;
use App\Http\Controllers\FollowsController;
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
//ログイン・登録関連


require __DIR__ . '/auth.php';
Route::group(['middleware' => 'auth'], function () {
  //投稿関連
  Route::get('/top', [PostsController::class, 'index']);
  Route::post('/postCreate', [PostsController::class, 'postCreate']);
  Route::post('/post/edit', [PostsController::class, 'postEdit']);
  Route::get('/delete/{id}', [PostsController::class, 'delete']);

  //プロフィール関連
  Route::get('/profile/{id}', [UsersController::class, 'showUserProfile'])->name('profile.user');
  Route::get('/profile', [UsersController::class, 'showMyProfile'])->name('profile.my');
  Route::post('/profile/edit', [UsersController::class, 'editMyProfile'])->name('profile.edit');
  //検索関連
  Route::get('/search', [UsersController::class, 'search']);
  Route::post('/search', [UsersController::class, 'search']);

  //ログアウト
  Route::get('/logout', [UsersController::class, 'logout']);

  //フォロー関連
  Route::post('/follow', [FollowsController::class, 'follow'])->name('follow');
  Route::post('/remove', [FollowsController::class, 'unfollow'])->name('unfollow');
  Route::get('/follow-list', [FollowsController::class, 'followList'])->name('follow.list');
  Route::get('/follower-list', [FollowsController::class, 'followerList'])->name('follower.list');
});

//ログアウト中のページ
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/added', [RegisterController::class, 'added'])->name('added');
