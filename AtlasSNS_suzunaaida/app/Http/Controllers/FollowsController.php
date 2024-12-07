<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowsController extends Controller
{
    public function follow(Request $request, User $user)
    {
        $request->user()->follow()->attach($user->id);

        return redirect()->back()->with('success', 'フォローしました！');
    }
    public function unfollow(Request $request, User $user)
    {
        $request->user()->follows()->detach($user->id);
        return redirect()->back()->with('success', 'フォロー解除しました！');
    }

    public function followList()
    {
        return view('follow_list');
    }
}
