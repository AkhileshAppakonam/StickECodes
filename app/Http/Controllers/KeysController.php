<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;
use App\User;

class KeysController extends Controller
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

    public function create()
    {
        return view('pages.createEncryptedKeys')->with('user', Auth::user());
    }
    
    public function show()
    {
        return view('pages.encryptedKeys');
    }
}
