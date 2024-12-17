<x-login-layout>
  <div class="follow-top">
    <h2>フォロワーリスト</h2>
    <div class="icon-wrapper">
      @forelse($followed as $follow)
      <a href="/profile/{{$follow->id}}">
      <img src="{{$follow->images === 'icon1.png' ? asset('images/icon1.png') : asset('images/' . $follow->images)}}" class="icon" alt="{{$follow->username}}'s icon">
      </a>
    @empty
      <p>フォローがいません</p>
    @endforelse
    </div>
  </div>

  <div>
    <ul>
      @forelse ($followed_posts as $post)
      <li class="timeline-list">
      <div class="timeline-box">
        <div class="tl-left">
        <a href="/profile/{{$post->user_id}}">
          <img src="{{ $post->user->images === 'icon1.png' ? asset('images/icon1.png') : asset('storage/' . $post->user->images) }}" class="icon" alt="{{ $post->user->username }}'s icon">
        </a>
        </div>
        <div class="tl-middle">
        <p>{{ $post->user->username }}</p>
        <p>{!! nl2br(e($post->post)) !!}</p>
        </div>
        <p class="tl-right">{{ $post->created_at->format('Y-m-d h:i') }}</p>
      </div>
      </li>
    @empty
      <p>投稿がありません</p>
    @endforelse
    </ul>
  </div>

</x-login-layout>
