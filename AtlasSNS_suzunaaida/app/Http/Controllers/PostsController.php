<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // モデルがApp\Modelsに存在する場合
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // フォローしているユーザーの投稿と自分自身の投稿を取得
        //$posts = Post::whereIn('user_id', $user->follows()->pluck('followed_id'))
        //->orWhere('user_id', $user->id)
        //->orderBy('created_at', 'desc')
        //->get();
        $posts = Post::get();

        return view('posts.index', ['posts' => $posts]);
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'post' => 'required|min:1|max:150',
        ]);

        // Eloquentのcreateメソッドを利用して投稿を作成
        $post = new Post([
            'user_id' => Auth::id(),
            'post' => $validated['post'],
        ]);

        $post->save();

        return redirect('/top');
    }

    public function postEdit(Request $request)
    {
        $validated = $request->validate([
            'editpost' => 'required|min:1|max:150',
        ]);

        $edit_id = $request->input('edit-id');
        $edit_post = $validated['editpost'];

        // 指定されたIDの投稿を更新
        $post = Post::findOrFail($edit_id);
        $post->post = $edit_post;
        $post->save();

        return redirect('/top');
    }

    public function delete(int $id)
    {
        // 指定されたIDの投稿を削除
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/top');
    }
}
