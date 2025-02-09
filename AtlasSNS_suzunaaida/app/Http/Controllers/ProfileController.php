<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class ProfileController extends Controller
{
    // 自分のプロフィールを表示
    public function showMyProfile()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->latest()->get();
        return view('users.profile', compact('user', 'posts'));
    }

    // 自分のプロフィールを編集・更新
    public function editMyProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|min:2|max:12',
            'email' => 'required|string|min:5|max:40|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|max:20|regex:/^[a-zA-Z0-9]+$/|confirmed',
            'bio' => 'nullable|max:150',
            'icon_image' => 'nullable|mimes:jpg,png,bmp,gif,svg|max:2048',
        ], [
            'username.required' => 'ユーザー名は必須項目です。',
            'username.min' => 'ユーザー名は2文字以上で入力してください。',
            'username.max' => 'ユーザー名は12文字以内で入力してください。',

            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => '正しいメールアドレスの形式で入力してください。',
            'email.unique' => 'このメールアドレスはすでに登録されています。',

            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは20文字以内で入力してください。',
            'password.regex' => 'パスワードは英数字のみ使用できます。',
            'password.confirmed' => 'パスワード確認が一致しません。',

            'bio.max' => '自己紹介は150文字以内で入力してください。',

            'icon_image.mimes' => 'アップロードできる画像の形式は jpg, png, bmp, gif, svg のみです。',
            'icon_image.max' => '画像のサイズは2MB以内でアップロードしてください。',
        ]);



        $updateData = $request->only(['username', 'email', 'bio']);

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->input('password'));
        }

        if ($request->hasFile('icon_image')) {
            if ($user->icon_image && $user->icon_image !== 'icon1.png') {
                Storage::delete('public/' . $user->icon_image);
            }

            $image = $request->file('icon_image');
            $imageName = $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/', $imageName);
            $updateData['icon_image'] = $imageName;
        }
        $user->update($updateData);

        return redirect()->route('profile.my')->with('success', 'プロフィールが更新されました。');
    }
}
