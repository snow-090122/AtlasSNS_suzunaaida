<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use PHPUnit\Framework\RiskyTestError;
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
  Route::get('/top', [PostsController::class, 'index']);
  Route::post('/postCreate', [PostsController::class, 'postCreate']);
  Route::post('/post/edit', [PostsController::class, 'postEdit']);
  Route::get('/delete/{id}', [PostsController::class, 'delete']);

  Route::get('/profile/{id}', [UsersController::class, 'profile']);
  Route::post('/profile/edit', [UsersController::class, 'profileEdit'])->name('profile.edit');

  Route::get('/search', [UsersController::class, 'search']);
  Route::post('/search', [UsersController::class, 'search']);


  Route::get('/logout', [UsersController::class, 'logout']);
});

//Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//Route::post('/login', [LoginController::class, 'login']);

//Route::get('/register', [RegisterController::class, 'register'])->name('register.store');
