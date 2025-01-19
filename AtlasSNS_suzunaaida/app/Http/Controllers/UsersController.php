<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;

class UsersController extends Controller
{
    // 他のユーザーのプロフィールを表示
    public function profile($id)
    {
        $user = User::find($id);
        $isFollowing = Auth::user()->following()->where('followed_id', $user->id)->exists();
        $posts = Post::where('user_id', $id)->latest()->get();

        return view('users.profile', compact('user', 'isFollowing', 'posts'));
    }

    // フォローする
    public function follow($id)
    {
        $user = User::find($id);
        Auth::user()->following()->attach($user->id);

        return redirect()->back();
    }

    // フォロー解除
    public function unfollow($id)
    {
        $user = User::find($id);
        Auth::user()->following()->detach($user->id);

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $users = User::where('id', '!=', Auth::id())
            ->when($keyword, function ($query, $keyword) {
                return $query->where('username', 'like', '%' . $keyword . '%');
            })
            ->get();

        return view('users.search', ['users' => $users, 'keyword' => $keyword]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
