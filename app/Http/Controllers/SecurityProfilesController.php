<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecurityProfilesController extends Controller
{
    public function index()
    {
        return view('pages.securityProfile');
    }

    public function edit()
    {
        return view('pages.editSecurityProfile');
    }
}
