<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(uniqid()), // rand pw
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }


    public function redirectToFacebook() 
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback() 
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $user = User::updateOrCreate([
            'email' => $facebookUser->getEmail(),
            'provider_id' => 'facebook' 
        ],
        [
            'name' => $facebookUser->getName(),
            'provider_id' => $facebookUser->getId(),
            'provider_name' => 'facebook',
            'password' => bcrypt(uniqid()),
        ]);
        Auth::login($user);

        return redirect('/dashboard');
    }
}
