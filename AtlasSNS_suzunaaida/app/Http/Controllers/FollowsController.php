<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowsController extends Controller
{
    public function followList()
    {
        $user = Auth::user();

        $follows = $user->following()->get();
        $follows_id = $user->following()->pluck('users.id')->toArray();

        $follows_posts = Post::with('user')
            ->whereIn('user_id', $follows_id)
            ->orderBy('created_at', 'desc')
            ->select('posts.*')
            ->get();

        return view('follows.followList', [
            'follows' => $user->following,
            'follows_posts' => $follows_posts,
        ]);
    }


    public function followerList(): \Illuminate\View\View
    {
        $user = Auth::user();

        $followed = Auth::user()->followers()->get();
        $followed_id = $followed->pluck('id');

        $followed_posts = Post::with('user')
            ->whereIn('user_id', $followed_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('follows.followerList', [
            'followed' => $followed,
            'followed_posts' => $followed_posts,
        ]);
    }
    // フォロー処理
    public function follow(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'followed_id' => 'required|exists:users,id',
        ]);

        $following_id = Auth::id();
        $followed_id = $request->get('followed_id');
        if (!Follow::where('following_id', $following_id)->where('followed_id', $followed_id)->exists()) {
            Follow::create([
                'following_id' => $following_id,
                'followed_id' => $followed_id,
            ]);
        }

        return back()->with('success', 'フォローしました。');
    }

    // フォロー解除処理
    public function unfollow(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'followed_id' => 'required|exists:users,id',
        ]);

        $followed_id = $request->input('followed_id');

        Follow::where([
            ['following_id', '=', Auth::id()],
            ['followed_id', '=', $followed_id],
        ])->delete();

        return back()->with('success', 'フォローを解除しました。');
    }
}
