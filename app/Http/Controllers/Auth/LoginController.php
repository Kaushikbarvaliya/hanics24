<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Import the Request class correctly
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Authentication passed, get the authenticated user
            $user = Auth::user();

            // Call the third-party API to retrieve the token
            $thirdPartyToken = $this->setThirdPartyToken($user);
            
            if (isset($thirdPartyToken) && $thirdPartyToken) {

                // Redirect to intended location or home
                return redirect()->intended($this->redirectTo);
            }

            return back()->withErrors([
                'email' => 'Something worng token not provided!',
            ]);
        }

        // If authentication fails, return back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Make an API call to retrieve the third-party token.
     *
     * @param $user
     * @return string|null
     */
    public static function setThirdPartyToken($user)
    {
         // Define the default body
         $body = [
            'oauth_id' => 'wwww',
            'name' => trim($user->firstname??''.' '.$user->lastname??''),
            'phone' => '',
            'email' => $user->email,
            'device_token' => 'usr45',
            'device_type' => 'ios',
            'app_version' => '3.3',
            'profile_image' => $user->avatar,
        ];

        // Make the API call using Laravel's HTTP client
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post(env('API_BASE_URL').'user/login', $body);

        // Check if the response is successful
        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['status']) && $responseData['status'] == "200") {
                if (isset($responseData,$responseData['status']) && $responseData['status'] == "200") {

                    // Store the token in the session (or handle it as needed)
                    session(['api_token' => $responseData['api_token']??'']);
                    session(['client_token' => $responseData['client_token']??'']);
    
                    // Redirect to intended location or home
                    return $responseData;
                }
            }
        }

        // Handle errors or return null if unable to retrieve the token
        return null;
    }
}
