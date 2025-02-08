<x-login-layout>
  {{-- エラーメッセージの表示 --}}
  @if($errors->any())
    <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
  @endif

  @if(Auth::id() === $user->id)
    <div class="auth-profile-box">
    <div class="profile-layout">
      <div class="profile-icon">
      @if(empty($user->icon_image) || $user->icon_image === 'icon1.png')
      <img src="{{ asset('images/icon1.png') }}" alt="プロフィールアイコン" class="icon">
    @else
      <img src="{{ asset('storage/' . $user->icon_image) }}" alt="プロフィールアイコン" class="icon">
    @endif
      </div>

      {{-- フォーム開始 --}}
      <div class="profile-form">
      {{ Form::open(['route' => 'profile.edit', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
      @csrf

      <div class="profile-row">
        <label for="username">ユーザー名</label>
        <input type="text" value="{{ old('username', $user->username) }}" name="username" id="username" required>
        @error('username')
      <span class="red">{{ $message }}</span>
    @enderror
      </div>

      <div class="profile-row">
        <label for="email">メールアドレス</label>
        <input type="email" value="{{ old('mail', $user->email) }}" name="email" id="mail" required>
        @error('email')
      <span class="red">{{ $message }}</span>
    @enderror
      </div>

      <div class="profile-row">
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
        @error('password')
      <span class="red">{{ $message }}</span>
    @enderror
      </div>

      <div class="profile-row">
        <label for="password_confirmation">パスワード確認</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
      </div>

      <div class="profile-row">
        <label for="bio">自己紹介</label>
        <textarea name="bio" id="bio" maxlength="150">{{ old('bio', $user->bio) }}</textarea>
        @error('bio')
      <span class="red">{{ $message }}</span>
    @enderror
      </div>

      <div class="profile-row">
        <label for="icon_image">アイコン画像</label>
        <div class="custom-upload">
        <label for="images" class="custom-upload-label">ファイルを選択</label>
        <input type="file" name="icon_image" id="images" accept=".jpg,.png,.bmp,.gif,.svg">
        <span id="file-name-display">ファイルが選択されていません</span>

        </div>
        @error('images')
      <div class="red">{{ $message }}</div>
    @enderror
      </div>

      <div class="profile-submit">
        <input type="submit" value="更新" class="profile-btn">
      </div>

      {{ Form::close() }}
      </div>
    </div>
    </div>
  @else
    <div class="profile-header">
    <!-- アイコン画像 -->
    @if($user->icon_image === 'icon1.png')
    <img src="{{ asset('images/icon1.png') }}" class="profile-icon">
  @else
  <img src="{{ asset('storage/' . $user->icon_image) }}" class="profile-icon">
@endif

    <!-- ユーザー情報 -->
    <div class="profile-wrapper">
      <div class="profile-section">
      <h3>ユーザー名</h3>
      <p>{{ $user->username }}</p>
      </div>
      <div class="profile-section">
      <h3>自己紹介</h3>
      <p>{{ $user->bio }}</p>
      </div>
    </div>

    @if(!Auth::user()->isFollowing($user->id))
    {{ Form::open(['url' => '/follow']) }}
    @csrf
    <input type="hidden" name="followed_id" value="{{ $user->id }}">
    <input type="submit" value="フォローする" class="btn follow-btn">
    {{ Form::close() }}
  @else
  {{ Form::open(['url' => '/remove']) }}
  @csrf
  <input type="hidden" name="followed_id" value="{{ $user->id }}">
  <input type="submit" value="フォロー解除" class="btn remove-btn">
  {{ Form::close() }}
@endif
    </div>

    <div>
    <ul class="timeline-list">
      @foreach($posts as $post)
      <li class="timeline-box">
      <div class="tl-left">
      @if($post->user->icon_image === 'icon1.png')
      <img src="{{ asset('images/icon1.png') }}" class="icon">
    @else
      <img src="{{ asset('storage/' . $post->user->icon_image) }}" class="icon">
    @endif
      </div>
      <div class="tl-middle">
      <p>{{ $post->user->username }}</p>
      <p>{!! nl2br(e($post->post)) !!}</p>
      </div>

      <p class="tl-right">{{ substr($post->created_at, 0, 16) }}</p>
      </li>
    @endforeach
    </ul>
    </div>
  @endif

</x-login-layout>
