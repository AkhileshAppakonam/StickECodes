<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecurityProfiles;
use App\Pages;
use App\Codes;
use App\User;

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
        $user = User::find($authId);
        $securityProfiles = $user->securityProfiles;
        $codes = $user->codes;
        $pages = $user->pages;
        $counts = $user->pages->groupBy('security_profile_id')->map->count();

        $tests = Codes::find($authId)->user->securityProfiles;


        echo $securityProfiles;
        echo "<br>";
        echo "<br>";
        echo $codes;
        echo "<br>";
        echo "<br>";
        echo $pages;
        echo "<br>";
        echo "<br>";
        echo $counts;
        echo "<br>";
        echo "<br>";
        echo $tests;
        echo "<br>";
        echo "<br>";

        foreach ($tests as $test) {
            echo $test;
            echo "<br>";
            echo "<br>";
        }

        // return view('pages.securityProfile')->with(['securityProfiles'=>$securityProfiles, 'codes'=>$codes, 'pages'=>$pages, 'counts'=>$counts]);
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
