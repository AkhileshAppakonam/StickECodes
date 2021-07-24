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
        // $codes = Codes::Join('pages', 'pages.code_id', '=', 'codes.id')->where('user_id', $authId)->select('codes.id', 'code_title', 'code_name', 'page_title')->get();
        // return view('pages.dashboard')->with('codes', $codes);
        $user = User::find($authId);
        $codes = $user->codes;
        $pages = $user->pages;

        return view('pages.dashboard')->with(['codes'=>$codes, 'pages'=>$pages]);
    }
}
