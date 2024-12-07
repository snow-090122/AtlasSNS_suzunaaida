<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'bio',
        'images'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //リレーション　ユーザの投稿
    public function posts()
    {
        $this->hasMany(Post::class);
    }

    //リレーション　フォローしているユーザー
    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }
    //リレーション　フォロワー
    public function followUsers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
    }

    //指定したユーザーをフォローしているかの確認
    public function isFollowing($user_id)
    {
        return $this->follows()->where('followed_id', $user_id)->exists();
    }

    //指定したユーザーをフォローする
    public function follow(User $user)
    {
        if (!$this->isFollowing($user->id)) {
            $this->follows()->attach($user->id);
        }
    }

    //指定したユーザーのフォローを解除する
    public function unfollow(User $user)
    {
        if ($this->isFollowing($user->id)) {
            $this->follows()->detach($user->id);
        }
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
    }
}
