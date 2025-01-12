<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;

class UsersController extends Controller
{
    public function showMyProfile()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->latest()->get();
        return view('users.profile', compact('user', 'posts'));
    }

    public function showUserProfile($id)
    {
        $user = User::findOrFail($id);
        $posts = Post::where('user_id', $user->id)->latest()->get();
        return view('users.profile', compact('user', 'posts'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
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

    public function editMyProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|min:2|max:12',
            'mail' => 'required|string|min:5|max:40|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|max:20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'bio' => 'nullable|max:150',
            'images' => 'nullable|mimes:jpg,png,bmp,gif,svg|max:2048',
        ]);

        $updateData = $request->only(['username', 'mail', 'bio']);

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->input('password'));
        }

        if ($request->hasFile('images')) {

            if ($user->icon_image && $user->icon_image !== 'icon1.png') {
                Storage::delete('public/' . $user->icon_image);
            }
            // 新しい画像の保存
            $image = $request->file('images');

            $imageName = $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();

            // ストレージに保存
            $image->storeAs('public/', $imageName);

            // データベースを更新
            $updateData['icon_image'] = $imageName;
        }

        $user->update($updateData);

        return redirect()->route('profile.my')->with('success', 'プロフィールが更新されました。');
    }
}
