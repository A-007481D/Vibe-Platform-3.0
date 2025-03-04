<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $post = Post::findOrFail($postId);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'content' => $request->content
        ]);

        return back()->with('success', 'Commentaire ajouté avec succès.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        if (Auth::id() == $comment->user_id) {
            $comment->delete();
            return back()->with('success', 'Commentaire supprimé avec succès.');
        }

        return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
    }
}