<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <!--IEブラウザ対策-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="ページの内容を表す文章" />
  <title></title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
  <!--スマホ,タブレット対応-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Scripts -->
  <script src="{{asset('js/jquery-3.7.1.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script src="js/script.js"></script>
  <!--サイトのアイコン指定-->
  <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
  <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
  <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
  <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
  <!--iphoneのアプリアイコン指定-->
  <link rel="apple-touch-icon-precomposed" href="画像のURL" />
  <!--OGPタグ/twitterカード-->
</head>

<body>
  <header>
    @include('layouts.navigation')
    <div id="head">
      <h1><a href="/top"><img src="{{asset('images/atlas.png')}}"></a></h1>
      <div id="head-container">
        <div id="head-menu">
          <p><span class="header-name">○○さん</span></p>
          <span class="triangle-btn"></span>
          @if(Auth::user()->images === 'icon1.png')
        <img class="icon" src="{{asset('images/icon1.png')}}">
      @else
      <img class="icon" src="{{asset('images/icon1.png')}}">
    @endif
        </div>
      </div>
    </div>
  </header>
  <!-- Page Content -->
  <div id="row">
    <div id="container">
      {{ $slot }}
    </div>
    <nav>
      <ul class="accordion-menu">
        <li><a href="/top">HOME</a></li>
        <li><a href="/profile/{{Auth::id()}}">プロフィール</a></li>
        <li><a href="/logout">ログアウト</a></li>
      </ul>
    </nav>
    <div id="side-bar">

      <div id="confirm">

        <p>{{Auth::user()->username}}さんの</p>
        <div class="confirm-count">
          <p>フォロー数</p>
          <p>{{Auth::user()->follows->count()}}名</p>
        </div>

        <p class="link follow-list-link"><a href="/follow-list">フォローリスト</a></p>
        <div class="confirm-count">
          <p>フォロワー数</p>
          <p>{{Auth::user()->followsUsers->count()}}名</p>
        </div>

        <p class="link follower-list-link"><a href="/follower-list">フォロワーリスト</a></p>
      </div>

      <p class="link search-link"><a href="/search">ユーザー検索</a></p>
    </div>
  </div>
  <footer>
  </footer>
</body>

</html>
