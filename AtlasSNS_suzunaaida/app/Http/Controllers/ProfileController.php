<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * プロフィールページを表示
     */
    public function profile()
    {
        $user = Auth::user(); // ログイン中のユーザー情報を取得
        return view('profile', compact('user')); // ビューにデータを渡す
    }

    /**
     * プロフィールを更新する
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        // フィールドの更新
        $user->username = $request->input('username');
        $user->mail = $request->input('mail');
        $user->bio = $request->input('bio');

        // パスワードの更新（必要な場合のみ）
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // プロフィール画像の更新
        if ($request->hasFile('images')) {
            // 古い画像を削除
            if ($user->profile_image && Storage::exists('public/' . $user->profile_image)) {
                Storage::delete('public/' . $user->profile_image);
            }

            // 新しい画像を保存
            $path = $request->file('images')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // データを保存
        $user->save();

        // 成功メッセージとリダイレクト
        return redirect()->route('top-page')->with('success', 'プロフィールを更新しました');
    }
}
