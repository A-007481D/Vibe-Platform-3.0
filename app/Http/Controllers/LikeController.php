<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike($postId)
    {
        $post = Post::findOrFail($postId);
        $like = Like::where('user_id', Auth::id())->where('post_id', $postId)->first();
        $isLiked = false;

        if ($like) {
            $like->delete();
            $message = 'Like retiré avec succès.';
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $postId
            ]);
            $isLiked = true;
            $message = 'Post aimé avec succès.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'isLiked' => $isLiked,
            'likesCount' => $post->likes()->count()
        ]);
    }
}