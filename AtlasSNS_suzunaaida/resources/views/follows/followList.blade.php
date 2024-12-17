<x-login-layout>
  <div class="follow-top">
    <h2>フォローリスト</h2>
    <div class="icon-wrapper">
      @if (!empty($follows) && $follows->isNotEmpty())
      @foreach ($follows as $item)
      <a href="/profile/{{$item->id}}">
      @if ($item->images === 'icon1.png')
      <img src="{{asset('images/icon1.png')}}" class="icon">
    @else
      <img src="{{asset('images/' . $item->images)}}" class="icon">
    @endif
      </a>
    @endforeach
    @else
      <p>フォローしているユーザーがいません。</p>
    @endif
    </div>
  </div>

  <div>
    <ul>
      @if (!empty($follows_post) && $follows_post->isNotEmpty())
      @foreach ($follows_post as $post)
<li class="timeline-list">
  <div class="timeline-box">
    <div class="tl-left">
      <a href="/profile/{{$post->user_id}}">
        @if ($post->user->images==='icon1.png')
        <img src="{{asset('images/icon3.png')}}" class="icon">
        @endif
        </a>
        </div>
        <div class="tl-middle">
          <p>{{$post->user->username}}</p>
          <p>{{!! nl2br(e($post->post)) !!}}</p>
          </div>
          <p class="tl-right">{{substr($post->created_at,0,16)}}</p>
          </div>
          </li>
      @endforeach
      @else
      <p>フォローしているユーザーの投稿がありません。</p>
      @endif
      </ul>
      </div>
</x-login-layout>
