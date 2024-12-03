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
    //編集画面を表示
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        //自分の投稿であるかどうか確認
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('posts.edit', ['post' => $post]);
    }

    //編集内容を保存
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'post' => 'required|min:1|max:150',
        ]);

        $post = Post::findOrFail($id);

        //自分の投稿であることの確認
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }
        $post->post = $validated['post'];
        $post->save();

        return redirect('/top')->with('status', '投稿が更新されました！');
    }
}
