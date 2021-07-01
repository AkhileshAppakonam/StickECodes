<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $codes = Codes::all();
        return view('pages.dashboard')->with('codes', $codes);
    }
}
