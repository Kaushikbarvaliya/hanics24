<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the profile for a given user.
     */
    public function index(Request $request)
    {
        session(['api_token' => '9b8f63314b764a8193bc350cc68e03d1']);
        session(['client_token' => '29cee58b02874a408adc2cb0d2fe1017']);
        return view('pages/device-list');
    }
}
