<x-login-layout>
  <div class="follow-top">
    <h2>フォローリスト</h2>
    <div class="icon-wrapper">
      @isset($follows)
      @if ($follows->isNotEmpty())
      @foreach ($follows as $follow)
      <a href="/profile/{{ $follow->id }}">
      @if($follow->images === 'icon1.png')
      <img src="{{asset('images/icon1.png')}}" class="icon">
    @else
      <img src="{{asset('storage/' . $follow->images)}}" class="icon">
    @endif
      </a>
    @endforeach
    @else
      <p>フォローしているユーザーがいません。</p>
    @endif
    @endisset
    </div>
  </div>

  <div>
    <ul>
      @isset($follows_posts)
      @if ($follows_posts->isNotEmpty())
      @foreach ($follows_posts as $post)
      <li class="timeline-list">
      <div class="timeline-box">
      <div class="tl-left">
      <a href="/profile/{{ $post->user_id }}">
      @if($post->user->images === 'icon1.png')
      <img src="{{asset('images/icon1.png')}}" class="icon">
    @else
      <img src="{{asset('storage/' . $post->user->images)}}" class="icon">
    @endif
      </a>
      </div>
      <div class="tl-middle">
      <p>{{ $post->user->username }}</p>
      <p>{!! nl2br(e($post->post)) !!}</p>
      </div>
      <p class="tl-right">{{ substr($post->created_at, 0, 16) }}</p>
      </div>
      </li>
    @endforeach
    @else
      <p>現在、フォローしているユーザーの投稿はありません。</p>
    @endif
    @endisset
    </ul>
  </div>
</x-login-layout>
