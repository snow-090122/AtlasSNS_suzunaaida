<x-login-layout>
  <div class="follow-top">
    <h2>フォローリスト</h2>
    <div class="icon-wrapper">
      @foreach ($follow as $follow)
      <a href="/profile/{{$follow->id}}">
      @if($follow->images === 'icon1.png')
      <img src="{{asset('images/icon1.png')}}" class="icon">
    @else
      <img src="{{asset('storage/' . $follow->images)}}" class="icon">
    @endif
      </a>
    @endforeach
    </div>
  </div>
  <div>
    <ul>
      @foreach($follow_post as $post)
      <li class="timeline-list">
      <div class="timeline-box">
        <div class="tl-left">
        <a href="/profile/{{$post->user_id}}">
          @if($post->user->images === 'icon.png')
        <img src="{{asset('images/icon1.png')}}" class="icon">
      @else
      <img src="{{asset('storage/' . $post->user->images)}}" class="icon">
    @endif
        </a>
        </div>
        <div class="tl-middle">
        <p>{{$post->user->username}}</p>
        <p>{!! nl2br(e($post->post))!!}</p>
        </div>
        <p class="tl-right">{{substr($post->created_at, 0, 16)}}</p>
      </div>
      </li>
    @endforeach
    </ul>
  </div>
</x-login-layout>
