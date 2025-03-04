<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        // Vérifier si l'utilisateur a le droit de voir ce profil
        $this->authorize('view', $user);

        return view('users.profile', compact('user'));
    }
}