<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class UsersController extends Controller
{
    //
    public function profile()
    {
        return view('users.profile');
    }
    public function search()
    {
        return view('users.search');
    }
    public function users()
    {
        return view('posts.index');
    }

    public function logout()
    {
        Auth::logout();
        return view('/login');
    }
}
