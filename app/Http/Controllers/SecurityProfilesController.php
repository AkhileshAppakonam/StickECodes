<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecurityProfiles;

class SecurityProfilesController extends Controller
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
    
    public function index()
    {
        $authId = auth()->user()->id;
        $securityProfiles = SecurityProfiles::where('user_id', $authId)->get();
        return view('pages.securityProfile')->with('securityProfiles', $securityProfiles);
    }

    public function show($secProfileId)
    {
        $authId = auth()->user()->id;
        $securityProfile = SecurityProfiles::where(['id'=>$secProfileId, 'user_id'=>$authId])->get()->first();

        if (empty($securityProfile)) {
            abort(403, 'Unauthorized action.');
        } else {
            return view('pages.editSecurityProfile')->with('securityProfile', $securityProfile);
        }
    }

    public function create()
    {
        return view('pages.createSecurityProfile');
    }
}
