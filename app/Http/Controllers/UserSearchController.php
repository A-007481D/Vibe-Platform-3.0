<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return back()->with('error', 'Veuillez entrer un terme de recherche');
        }

        $users = User::where(function($q) use ($query) {
            $q->where('email', 'like', "%{$query}%")
              ->orWhere('name', 'like', "%{$query}%")
              ->orWhere('last_name', 'like', "%{$query}%")
              ->orWhere('pseudo', 'like', "%{$query}%");
        })
        ->where('id', '!=', auth()->id()) // Exclure l'utilisateur actuel
        ->limit(10)
        ->get();

        if ($request->ajax()) {
            return response()->json([
                'users' => $users,
                'count' => $users->count()
            ]);
        }

        return view('search.index', compact('users', 'query'));
    }
}