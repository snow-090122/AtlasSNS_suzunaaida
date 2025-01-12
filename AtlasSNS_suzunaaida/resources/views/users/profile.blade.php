<x-login-layout>
  @if($users->id == Auth::id())
    <div class="auth-profile-box">
    <img src="{{ $users->profile_image ? asset('images/' . $users->profile_image) : asset('images/default-icon.png') }}" class="icon">
    {{ Form::open(['route' => 'profile.edit', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
    @csrf

    <div class="profile-edit">
      <label for="username">ユーザー名</label>
      <input type="text" value="{{ old('username', $users->username) }}" name="username" id="username" required>
      @error('username')
      <div class="red">{{ $message }}</div>
    @enderror
    </div>

    <div class="profile-edit">
      <label for="mail">メールアドレス</label>
      <input type="email" value="{{ old('mail', $users->mail) }}" name="mail" id="mail" required>
      @error('mail')
      <div class="red">{{ $message }}</div>
    @enderror
    </div>

    <div class="profile-edit">
      <label for="password">パスワード</label>
      <input type="password" name="password" id="password" placeholder="変更する場合のみ入力">
      @error('password')
      <div class="red">{{ $message }}</div>
    @enderror
    </div>

    <div class="profile-edit">
      <label for="password_confirmation">パスワード確認</label>
      <input type="password" name="password_confirmation" id="password_confirmation" placeholder="上記と同じパスワードを入力">
    </div>

    <div class="profile-edit">
      <label for="bio">自己紹介</label>
      <textarea name="bio" id="bio" maxlength="150" placeholder="自己紹介を入力">{{ old('bio', $users->bio) }}</textarea>
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

    <input type="hidden" name="id" value="{{ $users->id }}">
    <input type="submit" value="更新" class="profile-btn">
    {{ Form::close() }}
    </div>
  @endif
</x-login-layout>
