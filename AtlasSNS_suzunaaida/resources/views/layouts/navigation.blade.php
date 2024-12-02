<div id="head">
    <h1><a href="/top"><img src="{{asset('images/atlas.png')}}"></a></h1>
    <div id="head-container">
        <div id="{{Auth::user()->username}}">
            <p>aidaさん</p>
        </div>
        <ul>
            <li><a href="/top">ホーム</a></li>
            <li><a href="/profile">プロフィール</a></li>
            <li><a href="/logout">ログアウト</a></li>
        </ul>
    </div>
</div>
