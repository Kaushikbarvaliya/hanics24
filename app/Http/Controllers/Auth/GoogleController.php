<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists in your database
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Log the user in
                Auth::login($user);
            } else {
                // Create a new user if not found
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)), // Generate a random password
                ]);
                
                Auth::login($user);
            }

            return redirect()->intended('dashboard')->with('success', 'You have successfully logged in!');
        } catch (\Exception $e) {
            return redirect()->route('root')->with('error', 'Failed to login, please try again.');
        }
    }


}
