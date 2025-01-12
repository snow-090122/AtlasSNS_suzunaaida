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
        $users = User::findOrFail($id);
        $posts = Post::where('user_id', $id)->latest()->get();
        return view('users.profile', compact('users', 'posts'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $users = User::where('username', 'like', '%' . $keyword . '%')->where('id', '!=', Auth::id())->get();
        } else {
            $users = User::where('id', '!=', Auth::id())->get();
        }

        return view('users.search', ['users' => $users, 'keyword' => $keyword]);
    }

    public function profileEdit(Request $request)
    {
        $id = $request->input('id');
        $username = $request->input('username');
        $mail = $request->input('mail');
        $password = $request->input('password');
        $bio = $request->input('bio');
        $images = $request->file('images');

        $request->validate([
            'username' => 'required|string|min:2|max:12',
            'mail' => 'required|string|min:5|max:40|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|max:20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'bio' => 'max:150',
            'images' => 'nullable|mimes:jpg,png,bmp,gif,svg|max:2048',
        ]);

        $updateDate = [
            'username' => $username,
            'email' => $mail,
            'bio' => $bio,
        ];

        if (!empty($password)) {
            $updateDate['password'] = bcrypt($password);
        }
        if ($request->hasFile('images')) {
            // 画像を取得
            $images = $request->file('images');

            // ユニークなファイル名を生成し、保存
            $image_name = $images->hashName();
            $images->store('public');

            // データベースを更新
            User::find($id)->update(['images' => $image_name]);
        }

        if ($request->hasFile('images')) {
            $user = User::find($id);

            // 古い画像を削除
            if ($user->images) {
                Storage::delete('public/' . $user->images);
            }

            // 新しい画像を保存
            $image_name = $images->hashName();
            $images->store('public');

            // データベースを更新
            $user->update(['images' => $image_name]);
        }

        return redirect('/top');
    }
}
