<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostLike extends Component
{
    public $post;
    public $isLiked;
    public $likesCount;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->isLiked = $post->isLikedBy(Auth::id());
        $this->likesCount = $post->likesCount();
    }

    public function toggleLike()
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $this->post->id)->first();

        if ($like) {
            $like->delete();
            $this->isLiked = false;
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $this->post->id
            ]);
            $this->isLiked = true;
        }

        $this->likesCount = $this->post->fresh()->likesCount();
    }

    public function render()
    {
        return view('livewire.post-like');
    }
}