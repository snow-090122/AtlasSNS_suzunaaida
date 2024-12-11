<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;

class UsersController extends Controller
{
    //
    public function profile()
    {
        return view('users.profile');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $users = User::where('username', 'like', '%' . $keyword . '%')->get();
        return view('users.search', compact('users', 'keyword'));
    }
    public function users()
    {
        return view('posts.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
