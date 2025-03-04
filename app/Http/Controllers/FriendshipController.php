<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;


class FriendshipController extends Controller
{
    public function sendRequest($friendId)
    {
        // Vérifiez si la demande existe déjà
        if (Friendship::where('user_id', Auth::id())->where('friend_id', $friendId)->exists()) {
            return back()->with('error', 'Demande déjà envoyée.');
        }

        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $friendId,
            'accepted' => false,
        ]);

        return back()->with('success', 'Demande d\'ami envoyée.');
    }

    public function acceptRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);
        $friendship->accepted = true;
        $friendship->save();

        return back()->with('success', 'Demande d\'ami acceptée.');
    }

    public function rejectRequest($friendshipId)
    {
        $friendship = Friendship::findOrFail($friendshipId);
        $friendship->delete();

        return back()->with('success', 'Demande d\'ami rejetée.');
    }

    public function friendsList()
    {
        $friends = Friendship::where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhere('friend_id', Auth::id());
            })
            ->where('accepted', true)
            ->with(['user', 'friend']) // Recuperer les deux relations
            ->paginate(12);

        return view('friends.index', compact('friends'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('last_name', 'LIKE', "%{$query}%")
              ->orWhere('email', 'LIKE', "%{$query}%")
              ->orWhere('pseudo', 'LIKE', "%{$query}%");
        })
        ->where('id', '!=', Auth::id()) // Exclure l'utilisateur connecté
        ->get();

        return view('friends.search', compact('users'));
    }
    public function pendingRequests()
    {
        $pendingRequests = Friendship::where('friend_id', Auth::id())
            ->where('accepted', false)
            ->with('user')
            ->get();

        return view('friends.pending_requests', compact('pendingRequests'));
    }
    public function show($id)
    {
        $friendship = Friendship::findOrFail($id);
        
        $friend = ($friendship->user_id === Auth::id())
            ? $friendship->friend
            : $friendship->user;
    
        $posts = Post::where('user_id', $friend->id)
            ->latest()
            ->paginate(10);
    
        return view('friends.show', compact('friend', 'friendship', 'posts'));
    }
}
?>