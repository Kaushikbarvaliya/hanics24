<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TheatorController extends Controller
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
        return view('pages/theators-list');
    }

    public function graph(Request $request){
        return view('pages/theator-graph');
    }
}