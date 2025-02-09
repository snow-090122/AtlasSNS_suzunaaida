<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $followedUserIds = $user->following()->pluck('users.id');

        $posts = Post::whereIn('user_id', $followedUserIds)->orWhere('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('posts.index', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'post' => 'required|min:1|max:150',
        ], [
            'post.required' => '投稿内容は必須です。',
            'post.min' => '投稿内容は1文字以上で入力してください。',
            'post.max' => '投稿内容は150文字以内で入力してください。',
        ]);

        // Eloquentのcreateメソッドを利用して投稿を作成
        $post = new Post([
            'user_id' => Auth::id(),
            'post' => $validated['post'],
        ]);

        $post->save();

        return redirect('/top')->with('status', '投稿が作成されました！');
    }

    public function postEdit(Request $request)
    {
        $validated = $request->validate([
            'editpost' => 'required|min:1|max:150',
        ], [
            'editpost.required' => '投稿内容は必須です。',
            'editpost.min' => '投稿内容は1文字以上で入力してください。',
            'editpost.max' => '投稿内容は150文字以内で入力してください。',
        ]);

        $edit_id = $request->input('edit-id');
        $edit_post = $validated['editpost'];

        // 指定されたIDの投稿を更新
        $post = Post::findOrFail($edit_id);
        $post->post = $edit_post;
        $post->save();

        return redirect('/top')->with('status', '投稿が編集されました！');
    }

    public function delete(int $id)
    {
        // 指定されたIDの投稿を削除
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/top')->with('status', '投稿が削除されました！');
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
        ], [
            'post.required' => '投稿内容は必須です。',
            'post.min' => '投稿内容は1文字以上で入力してください。',
            'post.max' => '投稿内容は150文字以内で入力してください。',
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
