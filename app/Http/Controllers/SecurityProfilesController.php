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
        $user = User::with('securityProfiles.codes')->get()->find($authId);

        // echo $user;
        // echo "<br>";
        // echo "<br>";
        // echo $user->securityProfiles;
        // echo "<br>";
        // echo "<br>";
        // echo $user->codes;
        // echo "<br>";
        // echo "<br>";

        // foreach ($user->securityProfiles as $securityProfile) {
        //     echo "<br>";
        //     echo "<br>";
        //     echo $securityProfile;
        //     echo "<br>";
        //     echo $securityProfile->profile_name;
        //     echo "<br>";
        //     echo $securityProfile->codes->count();
        //     echo "<br>";
        //     foreach ($securityProfile->codes as $code) {
        //         echo $code->code_title;
        //         echo "<br>";
        //         echo $code->pivot->page_title;
        //         echo "<br>";
        //     }
        // }

        return view('pages.securityProfile')->with('user', $user);
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
