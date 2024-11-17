<x-login-layout>
  <div class="search-box">
    {{ Form::open(['url' => '/search']) }}
    @csrf
    {{ Form::input('text', 'keyword', '', ['placeholder' => 'ユーザー名', 'class' => 'search-text']) }}
    <input type="image" src="{{ asset('images/search.png')}}" class="btn" alt="検索">
    {{ Form::close() }}

    @if(isset($keyword))
    <p class="search-word">検索ワード：{{ $keyword }}</p>
  @endif
  </div>

  <div>
    <ul class="search-wrapper">
      @foreach($users as $user)
      <li class=search-list>
      @if($user->images === 'icon1.png')
      <img src="{{ asset('images/icon1.png')}}" class="icon">
    @else
      <img src="{{ asset('storage/' . $user->images)}}" class="icon">
    @endif
      <p>{{ $user->username }}</p>
      @if(!Auth::user()->isFollowing($user->id))
      {{ Form::open(['url' => '/follow']) }}
      @csrf
      <input type="hidden" name="followed_id" value="{{ $user->id }}">
      <input type="submit" value="フォローする" class="follow-btn">
      {{ Form::close() }}
    @else
      {{ Form::open(['url' => '/remove']) }}
      @csrf
      <input type="hidden" name="followed_id" value="{{ $user->id }}">
      <input type="submit" value="フォロー解除" class="remove-btn">
      {{ Form::close() }}
    @endif
      </li>
    </ul>
  </div>

</x-login-layout>
