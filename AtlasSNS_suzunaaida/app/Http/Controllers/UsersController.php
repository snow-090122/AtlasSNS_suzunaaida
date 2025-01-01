<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;

class UsersController extends Controller
{
    public function profile($id)
    {
        $user = User::findOrFail($id);
        $posts = Post::where('user_id', $id)->latest()->get();

        return view('profile', compact('user', 'posts'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $users = User::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where('username', 'like', '%' . $keyword . '%')
                    ->where('id', '!=', Auth::id());
            })
            ->where('id', '!=', Auth::id())
            ->get();

        return view('users.search', compact('users', 'keyword'));
    }

    public function profileEdit(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'username' => 'required|string|min:2|max:12',
            'mail' => 'required|string|email|min:5|max:40|unique:users,mail' . $id,
            'password' => 'nullable|min:8|max:20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'bio' => 'nullable|max:150',
            'images' => 'nullable|mimes:jpg,png,bmp,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'username' => $request->input('username'),
            'mail' => $request->input('mail'),
            'bio' => $request->input('bio'),
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->input('password'))]);
        }

        if ($request->hasFile('images')) {
            $imagesPath = $request->files('images')->store('public/images');
            $imagesName = basename($imagesPath);
            $user->update(['images' => $imagesName]);
        }

        return redirect('/top');
    }
}
