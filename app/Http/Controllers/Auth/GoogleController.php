<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller {
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request) {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            if(!empty($googleUser) && isset($googleUser->id,$googleUser->email)){

                $googleId = $googleUser->id;
                $googleUserData = $googleUser->user??'';
                
                $user = User::updateOrCreate([
                    'google_id' => $googleId,
                    'email' => $googleUser->getEmail()
                ], [
                    'firstname' => $googleUserData->given_name??'',
                    'lastname' => $googleUserData->family_name??'',
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUserData->picture??'',
                    'password' => bcrypt(Str::random(16)),
                    'google_id' => $googleId
                ]);

                Auth::login($user);

                return redirect()->intended('dashboard')->with('success', 'You have successfully logged in with Google!');
            }

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error('OAuth state mismatch: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Invalid state. Please try logging in again.');

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Google API Client Exception: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to authenticate with Google. Please try again later.');

        } catch (\Exception $e) {
            Log::error('General Exception during Google OAuth: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }



}
