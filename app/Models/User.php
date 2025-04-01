<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function likes()
{
    return $this->hasMany(Like::class);
}

public function hasLiked(Post $post)
{
    return $this->likes()->where('post_id', $post->id)->exists();
}

public function isAdmin()
{
    return (bool)$this->is_admin;
 // This should return 1 (or true) for admins.
}

 public function canAccessFilament(): bool
    {
        return (bool)$this->is_admin;
 // Change this if you use roles/permissions
    }

    public function listings()
{
    return $this->hasMany(\App\Models\Listing::class);
}

    public function posts()
{
    return $this->hasMany(Post::class);}

    public function messages()
{
    return $this->hasMany(\App\Models\Message::class, 'sender_id');
}

    public function receivedMessages()
{
    return $this->hasMany(\App\Models\Message::class, 'receiver_id');}
    

    

}
