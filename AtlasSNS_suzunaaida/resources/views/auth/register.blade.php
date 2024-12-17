<x-logout-layout>
    {!! Form::open(['url' => 'register']) !!}
    @csrf
    <h2>新規ユーザー登録</h2>

    {{ Form::label('ユーザー名') }}
    {{ Form::text('username', null, ['class' => 'input', 'required' => true]) }}

    {{ Form::label('メールアドレス') }}
    {{ Form::email('email', null, ['class' => 'input', 'required' => true]) }}

    {{ Form::label('パスワード') }}
    {{ Form::text('password', null, ['class' => 'input', 'required' => true]) }}

    {{ Form::label('パスワード確認') }}
    {{ Form::text('password_confirmation', null, ['class' => 'input', 'required' => true]) }}

    {{ Form::submit('登録', ['class' => 'btn']) }}

    <p><a href="/login">ログイン画面へ戻る</a></p>

    {!! Form::close() !!}


</x-logout-layout>
