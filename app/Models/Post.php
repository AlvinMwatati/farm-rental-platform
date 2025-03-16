<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'image',
        'video',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Replies
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // Relationship to Likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}