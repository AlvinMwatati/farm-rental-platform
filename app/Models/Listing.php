<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'condition',
        'location',
        'price',
        'image',
        'description',
        'user_id', // Ensure this is fillable
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($listing) {
            if (Auth::check()) {
                $listing->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
