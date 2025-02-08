<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <!-- IEブラウザ対策 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="AtlasはSNS機能を備えたシンプルで便利なプラットフォームです。" />
  <title>Atlas - SNSプラットフォーム</title>
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- スマホ、タブレット対応 -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Scripts -->
  <script src="http://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>
  <!-- サイトのアイコン -->
  <link rel="icon" href="{{ asset('images/favicon-16x16.png') }}" sizes="16x16" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32" type="image/png">
  <link rel="apple-touch-icon-precomposed" href="{{ asset('images/apple-touch-icon.png') }}">
</head>

<body>
  <header>
    @include('layouts.navigation')
    <div id="head">
      <h1><a href="/top"><img src="{{ asset('images/atlas.png') }}" alt="Atlas"></a></h1>
      <div id="head-container">
        <div id="head-menu">
          <div class="header-name-wrapper">
            <p><span class="header-name">{{ Auth::user()->username }}さん</span></p>
            <span class="triangle-btn"></span>
            @if(!empty(Auth::user()->icon_image) && file_exists(public_path('storage/' . Auth::user()->icon_image)))
        <img class="icon" src="{{ asset('storage/' . Auth::user()->icon_image) }}" alt="ユーザーアイコン">
      @else
    <img class="icon" src="{{ asset('images/icon1.png') }}" alt="デフォルトアイコン">
  @endif
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- メインコンテンツ -->
  <div id="row">
    <div id="container">
      {{ $slot }}
    </div>
    <nav>
      <ul class="accordion-menu">
        <li><a href="/top">HOME</a></li>
        <li><a href="/profile">プロフィール</a></li>
        <li><a href="/logout">ログアウト</a></li>
      </ul>
    </nav>

    <!-- サイドバー -->
    <div id="side-bar">
      <div id="confirm">
        <p>{{ Auth::user()->username }}さんの</p>
        <div class="confirm-count">
          <p>フォロー数</p>
          <p>{{ Auth::user()->follows->count() }}名</p>
        </div>
        <p class="link follow-list-link"><a href="/follow-list">フォローリスト</a></p>
        <div class="confirm-count">
          <p>フォロワー数</p>
          <p>{{ Auth::user()->followers->count() }}名</p>
        </div>
        <p class="link follower-list-link"><a href="/follower-list">フォロワーリスト</a></p>
      </div>
      <p class="link search-link"><a href="/search">ユーザー検索</a></p>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 Atlas. All rights reserved.</p>
  </footer>
</body>

</html>
