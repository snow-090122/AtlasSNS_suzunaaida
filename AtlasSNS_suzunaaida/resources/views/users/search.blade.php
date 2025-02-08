<x-login-layout>
  <div class="search-box">
    {{Form::open(['url' => '/search', 'class' => 'search-container'])}}
    @csrf
    {{Form::input('text', 'keyword', '', ['placeholder' => 'ユーザー名', 'class' => 'search-box'])}}
    <input type="image" src="{{asset('images/search.png')}}" class="search-btn" alt="検索">
    {{Form::close()}}

    @if (isset($keyword))
    <p class="search-word">検索ワード:{{$keyword}}</p>
  @endif
  </div>

  <div>
    <ul class="search-wrapper">
      @foreach($users as $user)
      <li class="search-list">
      @if(empty($user->icon_image) || $user->icon_image === 'icon1.png')
      <img src="{{ asset('images/icon1.png') }}" class="icon" alt="デフォルトアイコン">
    @else
      <img src="{{ asset('storage/' . $user->icon_image) }}" class="icon" alt="ユーザーアイコン">
    @endif

      <p>{{$user->username}}</p>
      @if(Auth::user()->isFollowing($user->id))
      {{Form::open(['route' => 'unfollow'])}}
      @csrf
      <input type="hidden" name="followed_id" value="{{$user->id}}">
      <input type="submit" value="フォロー解除" class="remove-btn">
      {{Form::close()}}
    @else
      {{Form::open(['route' => 'follow'])}}
      @csrf
      <input type="hidden" name="followed_id" value="{{$user->id}}">
      <input type="submit" value="フォローする" class="follow-btn">
      {{Form::close()}}
    @endif
      </li>
    @endforeach
    </ul>
  </div>
</x-login-layout>
