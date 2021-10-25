<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecurityProfiles;
use App\Pages;
use App\Codes;
use App\User;
use App\SecurityProfileUsers;
use App\PageUsers;

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
        $securityProfileUsers = SecurityProfileUsers::where('security_profile_id', $secProfileId)->with('user')->get();

        // echo $securityProfileUsers;
        // echo "<br>";
        // echo "<br>";

        // foreach ($securityProfileUsers as $securityProfileUser) {
        //     echo $securityProfileUser->permissions;
        //     echo "<br>";
        //     echo $securityProfileUser->user->name;
        //     echo "<br>";
        //     echo $securityProfileUser->user->email;
        //     echo "<br>";
        // }

        // echo "<br>";
        // echo "<br>";

        // echo count($securityProfileUsers->pluck('user'));
        // echo "<br>";
        // echo count($securityProfileUsers);

        if (empty($securityProfile)) {
            abort(403, 'Unauthorized action.');
        } else {
            return view('pages.editSecurityProfile')->with(['securityProfile'=>$securityProfile, 'securityProfileUsers'=>$securityProfileUsers]);
        }
    }

    public function create()
    {
        return view('pages.createSecurityProfile');
    }

    public function edit(Request $request, $secProfileId)
    {
        $validated = $request->validate([
            'securityProfileName' => 'required',
            'profileType' => 'nullable|string',
            'userCount' => 'required'
        ]);

        $userCount = $request->input('userCount');
        $DBspUsersCount = $request->input('DBspUsersCount');
        $DBspUsersCountRemaining = $request->input('DBspUsersCountRemaining');

        // Check optional filed to make profile public
        if (!$request->has('profileType')) {
            $profileType = 'priv';
        } else {
            $profileType = $request->input('profileType');
        }
        
        // echo $request->input('securityProfileName');
        // echo "<br>";
        // echo $profileType;
        // echo "<br>";
        // echo $userCount;
        // echo "<br>";

        // Dealing with New SP Users
        for ($i=0; $i <= $userCount-$DBspUsersCountRemaining; $i++) { 
            if ($request->filled('addUserEmail'.$i) || $request->filled('addUserName'.$i)) {
                $request->validate([
                    'addUserEmail'.$i => 'required|email',
                    'addUserName'.$i => 'required',
                    'addUserPermissions'.$i => 'required'
                ],
                [
                    'addUserEmail'.$i.'.required' => 'An Email is Required on Row '.($i+1),
                    'addUserEmail'.$i.'.email' => 'Please Enter a Valid Email on Row '.($i+1),
                    'addUserName'.$i.'.required' => 'A Name is Required on Row '.($i+1),
                    'addUserPermissions'.$i.'.required' => 'Please Select Appropriate Permissions on Row '.($i+1)
                ]);

                // echo $request->input('addUserEmail'.$i);
                // echo "<br>";
                // echo $request->input('addUserName'.$i);
                // echo "<br>";
                // echo $request->input('addUserPermissions'.$i);
                // echo "<br>";

                if ($request->input('addUserPermissions'.$i) == "view") {
                    $permissions = 1;
                } elseif ($request->input('addUserPermissions'.$i) == "update") {
                    $permissions = 2;
                } elseif ($request->input('addUserPermissions'.$i) == "full") {
                    $permissions = 3;
                }

                $SPUserId = User::where([
                                'email' => $request->input('addUserEmail'.$i), 
                                'name' => $request->input('addUserName'.$i) 
                            ])->first('id')->id;

                // echo $permissions;
                // echo "<br>";
                // echo "Security Profile User Id: ".$SPUserId;
                // echo "<br>";

                $securityProfileUsers = new SecurityProfileUsers;
                $securityProfileUsers->created_at = NOW();
                $securityProfileUsers->updated_at = NOW();
                $securityProfileUsers->security_profile_id = $secProfileId;
                $securityProfileUsers->user_id = $SPUserId;
                $securityProfileUsers->invitee_id = 0;
                $securityProfileUsers->permissions = $permissions;
                $securityProfileUsers->save();

                // echo "Security Profile Id: ".$secProfileId;
                // echo "<br>";

                $SPPageIds = SecurityProfiles::find($secProfileId)->pages;

                // echo "Security Profile Page Id: ".$SPPageIds;
                // echo "<br>";
                // echo "<br>";

                foreach ($SPPageIds as $SPPageId) {
                    $pageUsers = new PageUsers;
                    $pageUsers->created_at = NOW();
                    $pageUsers->updated_at = NOW();
                    $pageUsers->user_id = $SPUserId;
                    $pageUsers->page_id = $SPPageId->id;
                    $pageUsers->permissions = $permissions;
                    $pageUsers->invitee_id = 0;
                    $pageUsers->user_type = 'spu';
                    $pageUsers->save();
                }
            }
        }

        // Update Existing SP Users
        for ($j=0; $j <= $DBspUsersCount-1; $j++) { 
            if ($request->filled('addUserEmailUpdate'.$j) || $request->filled('addUserNameUpdate'.$j)) {
                $request->validate([
                    'addUserEmailUpdate'.$j => 'required|email',
                    'addUserNameUpdate'.$j => 'required',
                    'addUserPermissionsUpdate'.$j => 'required',
                    'securityProfileUserId'.$j => 'required'
                ],
                [
                    'addUserEmailUpdate'.$j.'.required' => 'An Email is Required on Row '.($j+1),
                    'addUserEmailUpdate'.$j.'.email' => 'Please Enter a Valid Email on Row '.($j+1),
                    'addUserNameUpdate'.$j.'.required' => 'A Name is Required on Row '.($j+1),
                    'addUserPermissionsUpdate'.$j.'.required' => 'Please Select Appropriate Permissions on Row '.($j+1)
                ]);

                $SPUserIdUpdate = User::where([
                    'email' => $request->input('addUserEmailUpdate'.$j), 
                    'name' => $request->input('addUserNameUpdate'.$j) 
                ])->first('id')->id;

                if ($request->input('addUserPermissionsUpdate'.$j) == "view") {
                    $permissionsUpdate = 1;
                } elseif ($request->input('addUserPermissionsUpdate'.$j) == "update") {
                    $permissionsUpdate = 2;
                } elseif ($request->input('addUserPermissionsUpdate'.$j) == "full") {
                    $permissionsUpdate = 3;
                }


                $securityProfileUsers = SecurityProfileUsers::find($request->input('securityProfileUserId'.$j));
                // $securityProfileUsers->updated_at = NOW();
                // $securityProfileUsers->user_id = $SPUserIdUpdate;
                // $securityProfileUsers->permissions = $permissionsUpdate;
                // $securityProfileUsers->save();

                echo $securityProfileUsers;
                echo "<br>";

                $pageUsers = Pages::where('security_profile_id', $secProfileId)->with('page_users')->get();
                
                echo $pageUsers;
                echo "<br>";
                echo "<br>";

            } else {
                
            }
        }

        // $securityProfile = SecurityProfiles::find($secProfileId);
        // $securityProfile->updated_at = NOW();
        // $securityProfile->profile_type = $profileType;
        // $securityProfile->profile_name = $request->input('securityProfileName');
        // $securityProfile->save();

        // return redirect('/securityProfilePage')->with('success', $securityProfile->profile_name.': Security Profile Updated Successfully');

    }
}
