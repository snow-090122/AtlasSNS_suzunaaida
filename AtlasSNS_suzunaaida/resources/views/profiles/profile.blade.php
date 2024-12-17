<x-login-layout>
  @if($users->id == Auth::id())
    <div class="auth-profile-box">

    @if($users->images === 'icon1.png')
    <img src="{{asset('images/icon1.png')}}" class="icon">
  @else
  <img src="{{asset('storage/' . $users->images)}}" class="icon">
@endif
    {{ Form::open(['route' => 'profile.edit', 'enctype' => 'multipart/form-data']) }}
    @csrf


    <div class="profile-edit">
      <label for="username">ユーザー名</label>
      <input type="text" value="{{ $users->username }}" name="username" id="username" min="2" max="12" required>
    </div>
    @error('username')
    <div class="red">{{ $message }}</div>
  @enderror

    <div class="profile-edit">
      <label for="mail">メールアドレス</label>
      <input type="email" value="{{ $users->mail }}" name="mail" id="mail" min="5" max="40" required>
    </div>
    @error('mail')
    <div class="red">{{ $message }}</div>
  @enderror

    <div class="profile-edit">
      <label for="password">パスワード</label>
      <input type="password" name="password" id="password" min="8" max="20" pattern="^[0-9a-zA-Z]+$" required>
    </div>
    @error('password')
    <div class="red">{{ $message }}</div>
  @enderror
    <div class="profile-edit">
      <label for="password_confirmation">パスワード確認</label>
      <input type="password" name="password_confirmation" id="password_confirmation" min="8" max="20" required>
    </div>


    <div class="profile-edit">
      <label for="bio">自己紹介</label>
      <input type="text" value="{{ $users->bio }}" name="bio" id="bio" maxlength="150">
    </div>
    @error('bio')
    <div class="red">{{ $message }}</div>
  @enderror

    <div class="profile-edit">
      <label for="images">アイコン画像</label>
      <label for="images" class="custom-upload">ファイルを選択</label>

      <input type="file" name="images" id="images" accept=".jpg,.png,.bmp,.gif,.svg" class="file-upload" hidden>
    </div>
    @error('images')
    <div class="red">{{ $message }}</div>
  @enderror

    <input type="hidden" name="id" value="{{ $users->id }}">
    <input type="submit" value="更新" class="profile-btn">
    {{ Form::close() }}
    </div>

  @else
    <div class="profile-top">
    @if($users->images === 'icon1.png')
    <img src="{{asset('images/icon1.png')}}" class="icon">
  @else
  <img src="{{asset('storage/' . $users->images)}}" class="icon">
@endif

    <div class="profile-wrapper">
      <div class="other-profile">
      <p class="profile-title">ユーザー名</p>
      <p class="profile-text">{{ $users->username }}</p>
      </div>
      <div class="other-profile">
      <p class="profile-title">自己紹介</p>
      <p class="profile-text">{{ $users->bio }}</p>
      </div>
    </div>

    @if(!Auth::user()->isFollowing($users->id))

  {{ Form::open(['url' => Auth::user()->isFollowing($users->id) ? '/remove' : '/follow']) }}
<input type="hidden" name="followed_id" value="{{ $users->id }}">
<input type="submit" value="{{ Auth::user()->isFollowing($users->id) ? 'フォロー解除' : 'フォローする' }}" class="{{ Auth::user()->isFollowing($users->id) ? 'remove-btn' : 'follow-btn' }}">
{{ Form::close() }}

    </div>

    <div>
    <ul>
      @foreach($posts as $post)
      <li class="timeline-list">
      <div class="timeline-box">
      <div class="tl-left">
      @if($post->user->images === 'icon1.png')
      <img src="{{asset('images/icon1.png')}}" class="icon">
    @else
      <img src="{{asset('storage/' . $post->user->images)}}" class="icon">
    @endif
      </div>
      <div class="tl-middle">
      <p>{{ $post->user->username }}</p>
      <p>{!! nl2br(e($post->post)) !!}</p>
      </div>
      <p class="tl-right">{{ substr($post->created_at, 0, 16) }}</p>
      </div>
      </li>
    </ul>
    </div>
  @endif
</x-login-layout>
