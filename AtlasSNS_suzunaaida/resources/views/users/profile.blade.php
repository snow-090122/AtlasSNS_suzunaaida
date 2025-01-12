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
    @if($user->images === 'icon1.png')
    <img src="{{asset('images/icon1.png')}}" class="icon">
  @else
  <img src="{{asset('storage/' . $user->images)}}" class="icon">
@endif
    {{ Form::open(['route' => 'profile.edit', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
    @csrf

    <div class="profile-edit">
      <label for="username">ユーザー名</label>
      <input type="text" value="{{ old('username', $user->username) }}" name="username" id="username" required>
      @error('username')
      <div class="red">{{ $message }}</div>
    @enderror
    </div>

    <div class="profile-edit">
      <label for="mail">メールアドレス</label>
      <input type="email" value="{{ old('mail', $user->email) }}" name="mail" id="mail" required>
      @error('mail')
      <div class="red">{{ $message }}</div>
    @enderror
    </div>

    <div class="profile-edit">
      <label for="password">パスワード</label>
      <input type="password" name="password" id="password">
      @error('password')
      <div class="red">{{ $message }}</div>
    @enderror
    </div>

    <div class="profile-edit">
      <label for="password_confirmation">パスワード確認</label>
      <input type="password" name="password_confirmation" id="password_confirmation">
    </div>

    <div class="profile-edit">
      <label for="bio">自己紹介</label>
      <textarea name="bio" id="bio" maxlength="150" placeholder="自己紹介を入力">{{ old('bio', $user->bio) }}</textarea>
      @error('bio')
      <div class="red">{{ $message }}</div>
    @enderror
    </div>

    <div class="profile-edit">
      <label for="images">アイコン画像</label>
      <label for="images" class="custom-upload">ファイルを選択</label>
      <input type="file" name="images" id="images" accept=".jpg,.png,.bmp,.gif,.svg" class="file-upload" hidden>
      @error('images')
      <div class="red">{{ $message }}</div>
    @enderror
    </div>

    <input type="submit" value="更新" class="profile-btn">
    {{ Form::close() }}
    </div>
  @else
    <div class="alert alert-warning">
    <p>このプロフィールは編集できません。</p>
    </div>
  @endif
</x-login-layout>
