<x-logout-layout>
  {!! Form::open(['url' => '/login', 'class' => 'form-container']) !!}

  <!-- タイトル -->
  <p class="form-title">AtlasSNSへようこそ</p>

  <!-- メールアドレス入力 -->
  <div class="form-group">
    {{ Form::label('email', 'メールアドレス', ['class' => 'label-right']) }}
    {{ Form::text('email', null, ['class' => 'input', 'required' => true]) }}
  </div>

  <!-- パスワード入力 -->
  <div class="form-group">
    {{ Form::label('password', 'パスワード', ['class' => 'label-right']) }}
    {{ Form::password('password', ['class' => 'input', 'required' => true]) }}
  </div>

  <!-- ログインボタン -->
  <div class="btn-container-right">
    {{ Form::submit('ログイン', ['class' => 'btn']) }}
  </div>

  <!-- 新規ユーザーリンク -->
  <p class="register-link"><a href="/register">新規ユーザーの方はこちら</a></p>

  {!! Form::close() !!}
</x-logout-layout>
