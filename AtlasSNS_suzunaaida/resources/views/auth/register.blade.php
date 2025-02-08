<x-logout-layout>
    {!! Form::open(['url' => 'register', 'class' => 'form-container']) !!}
    @csrf

    <!-- タイトル -->
    <h2 class="form-title">新規ユーザー登録</h2>

    <!-- ユーザー名 -->
    {{ Form::label('username', 'ユーザー名', ['class' => 'label']) }}
    {{ Form::text('username', null, ['class' => 'input', 'required' => true]) }}
    @error('username')
        <span class="error">{{$message}}</span>
    @enderror

    <!-- メールアドレス -->
    {{ Form::label('email', 'メールアドレス', ['class' => 'label']) }}
    {{ Form::email('email', null, ['class' => 'input', 'required' => true]) }}
    @error('email')
        <span class="error">{{$message}}</span>
    @enderror

    <!-- パスワード -->
    {{ Form::label('password', 'パスワード', ['class' => 'label']) }}
    {{ Form::password('password', ['class' => 'input', 'required' => true]) }}
    @error('password')
        <span class="error">{{$message}}</span>
    @enderror

    <!-- パスワード確認 -->
    {{ Form::label('password_confirmation', 'パスワード確認', ['class' => 'label']) }}
    {{ Form::password('password_confirmation', ['class' => 'input', 'required' => true]) }}
    @error('password_confirmation')
        <span class="error">{{$message}}</span>
    @enderror

    <!-- ボタン -->
    <div class="btn-container-right">
        {{ Form::submit('新規登録', ['class' => 'btn']) }}
    </div>

    <!-- ログイン画面へのリンク -->
    <p class="register-link"><a href="/login">ログイン画面へ戻る</a></p>

    {!! Form::close() !!}
</x-logout-layout>
