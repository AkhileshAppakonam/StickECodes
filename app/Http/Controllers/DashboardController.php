<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Codes;
use App\Pages;
use App\User;

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
        $authId = auth()->user()->id;
        $user = User::with('codes.pages')->find($authId);

        // echo $user;
        // echo "<br>";
        // echo "<br>";

        // foreach ($user->codes as $code) {
        //     echo $code->code_title;
        //     echo "<br>";
        //     foreach ($code->pages as $page) {
        //         echo $page->page_title;
        //         echo "<br>";
        //     }
        // }

        return view('pages.dashboard')->with('user', $user);
    }
}
