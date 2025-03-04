<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Friendship;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('posts.index', compact('posts'));
    }

    public function friendsPosts()
    {
        $userId = Auth::id();
        
        $friendIds = Friendship::where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('friend_id', $userId);
            })
            ->where('accepted', true)
            ->get()
            ->map(function ($friendship) use ($userId) {
                if ($friendship->user_id == $userId) {
                    return $friendship->friend_id;
                }
                return $friendship->user_id;
            })
            ->toArray();
        
        $friendIds[] = $userId;
        
        $posts = Post::whereIn('user_id', $friendIds)
            ->latest()
            ->paginate(10);
        
        return view('posts.friendsPosts', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('posts', 'public') : null;

        Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post créé avec succès !');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->update(['image_path' => $imagePath]);
        }

        $post->update(['content' => $request->content]);

        return redirect()->route('posts.index')->with('success', 'Post mis à jour !');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post supprimé !');
    }
}
