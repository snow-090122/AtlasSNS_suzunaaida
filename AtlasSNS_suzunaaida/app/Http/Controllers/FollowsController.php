<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowsController extends Controller
{
    public function follow(Request $request)
    {
        //リクエストからフォロー対象のユーザーIDを取得
        $userId = $request->input('followed_id');
        //フォロー対象のユーザーを取得
        $followedUser = User::findOrFail($userId);
        //現在のログインユーザーがフォローする
        $request->user()->follow($followedUser);

        return redirect()->back()->with('success', 'フォローしました！');
    }
    public function unfollow(Request $request, User $user)
    {
        $request->user()->follows()->detach($user->id);
        return redirect()->back()->with('success', 'フォロー解除しました！');
    }

    public function followerList(Request $request)
    {
        $followers = $request->user()->followers()->get();
        return view('follower_list', compact('followers'));
    }
}
