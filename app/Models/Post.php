<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'image_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    public function isLikedBy($userId = null)
    {
        $userId = $userId ?? Auth::id();
        return $this->likes()->where('user_id', $userId)->exists();
    }
    
    public function likesCount()
    {
        return $this->likes()->count();
    }
}