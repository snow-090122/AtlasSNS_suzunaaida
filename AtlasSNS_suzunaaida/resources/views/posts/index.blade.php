<x-login-layout>

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
    @if(empty(Auth::user()->icon_image) || Auth::user()->icon_image === 'icon1.png')
    <img class="icon" src="{{ asset('images/icon1.png') }}">
  @else
  <img class="icon" src="{{ asset('storage/' . Auth::user()->icon_image) }}">
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
        @if(empty($post->user->icon_image) || $post->user->icon_image === 'icon1.png')
      <img class="icon" src="{{ asset('images/icon1.png') }}" alt="デフォルトアイコン">
    @else
    <img class="icon" src="{{ asset('storage/' . $post->user->icon_image) }}" alt="ユーザーアイコン">
  @endif
        </div>

        <div class="tl-middle">
        <p>{{ $post->user->username }}</p>
        <p>{!! nl2br(e($post->post, false)) !!}</p>
        </div>

        <div class="tl-right">
        <p class="post-date">{{ substr($post->created_at, 0, 16) }}</p>
        @if($post->user_id == Auth::user()->id)
      <div class="buttons">
        <a class="modalOpen" post="{{ $post->post }}" post_id="{{ $post->id }}">
        <img class="edit-btn btn" src="{{ asset('images/edit.png') }}" alt="編集">
        </a>
        <a href="/delete/{{ $post->id }}" class="delete-box" onclick="return confirm('この投稿を削除します。よろしいでしょうか？')">
        <img class="delete-btn btn" src="{{ asset('images/trash.png') }}" alt="削除">
        <img class="delete-btn btn" src="{{ asset('images/trash-h.png') }}" alt="削除">
        </a>
      </div>
    @endif
        </div>
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
</x-login-layout>
