<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'recipient_id',
    ];

    // Relationship to User (who shared the post)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relationship to Recipient (who received the shared post)
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}