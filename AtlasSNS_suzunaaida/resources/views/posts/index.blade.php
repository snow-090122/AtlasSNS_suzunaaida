<x-login-layout>
  @extends('layouts.login')

  @section('content')

  <div class="post-box">
    @if($errors->any())
    <ul>
      @foreach($errors->all() as $error)
      <li class="red">{{ $error }}</li>
    @endforeach
    </ul>
  @endif

    {{ Form::open(['url' => '/postCreate']) }}
    @csrf
    @if(Auth::user()->images === 'icon1.png')
    <img class="icon" src="{{ asset('images/icon1.png') }}">
  @else
  <img class="icon" src="{{ asset('storage/' . Auth::user()->images) }}">
@endif
    {{ Form::textarea('post', '', ['class' => 'post-form', 'placeholder' => '投稿内容を入力してください。']) }}
    <input type="image" name="submit" src="{{ asset('images/post.png') }}" alt="送信" class="submit-btn btn">
    {{ Form::close() }}

  </div>
  <div>
    <ul>
      @foreach($posts as $post)
      <li class="timeline-list">
      <div class="timeline-box">
        <div class="tl-left">
        @if($post->user->images === 'icon1.png')
      <img class="icon" src="{{ asset('images/icon1.png') }}">
    @else
    <img class="icon" src="{{ asset('storage/' . $post->user->images) }}">
  @endif
        </div>
        <div class="tl-middle">
        <p>{{ $post->user->username }}</p>
        <p>{!! nl2br(e($post->post, false)) !!}</p>
        </div>
        <p class="tl-right">{{ substr($post->created_at, 0, 16) }}</p>
      </div>

      <div class="btn-wrapper">
        @if($post->user_id == Auth::user()->id)
      <a class="modalopen" post="{{ $post->post }}" post_id="{{ $post->id }}">
      <img class="edit-btn btn" src="{{ asset('images/edit.png') }}" alt="編集">
      </a>
      <a href="/delete/{{ $post->id }}" class="delete-box" onclick="return confirm('この投稿を削除します。よろしいでしょうか？')">
      <img class="delete-btn btn" src="{{ asset('images/trash.png') }}" alt="削除">
      <img class="delete-btn btn" src="{{ asset('images/trash-h.png') }}" alt="削除">
      </a>
    @endif
      </div>
      </li>
    @endforeach
    </ul>

    <!-- モーダルウィンドウ -->
    <div class="modal-main">
      <div class="modal-inner"></div>
      <div class="modal-box">
        {{ Form::open(['url' => '/post/edit', 'id' => 'modal-form']) }}
        @csrf
        <textarea class="edit-post" name="editpost"></textarea>
        <input type="hidden" class="edit-id" name="edit-id">
        <input type="submit" class="edit-btn-modal btn" value="">
        {{ Form::close() }}
      </div>
    </div>
  </div>
  @endsection
</x-login-layout>
