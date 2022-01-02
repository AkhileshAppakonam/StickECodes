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
        $user = auth()->user();

        // echo $user;
        // echo "<br>";
        // echo "<br>";
        // echo $user->securityProfiles;
        // echo "<br>";
        // echo "<br>";

        // foreach ($user->securityProfiles as $securityProfile) {
        //     echo "<br>";
        //     echo "<br>";
        //     echo $securityProfile;
        //     echo "<br>";
        //     echo $securityProfile->profile_name;
        //     echo "<br>";
        //     echo $securityProfile->codes;
        //     echo "<br>";
        //     echo $securityProfile->codes->count();
        //     echo "<br>";
        //     echo $securityProfile->security_profile_users;
        //     echo "<br>";

        //     foreach ($securityProfile->codes as $code) {
        //         echo $code->code_title;
        //         echo "<br>";
        //         echo $code->pivot->page_title;
        //         echo "<br>";
        //     }

        //     foreach ($securityProfile->security_profile_users as $securityProfileUser) {
        //         echo "<br>";
        //         echo $securityProfileUser->user->name;
        //         echo "<br>";
        //     }
        // }

        return view('pages.securityProfile')->with('user', $user);
    }

    public function show(SecurityProfiles $secProfile)
    {
        $this->authorize('editSecurityProfile', $secProfile);

        return view('pages.editSecurityProfile')->with('securityProfile', $secProfile);
        
        // if ($secProfileId != -1) {
        //     $authId = auth()->user()->id;
        //     $securityProfile = SecurityProfiles::where(['id'=>$secProfileId, 'user_id'=>$authId])->get()->first();
        //     $securityProfileUsers = SecurityProfileUsers::where('security_profile_id', $secProfileId)->with('user')->get();

        //     // echo $securityProfileUsers;
        //     // echo "<br>";
        //     // echo "<br>";

        //     // foreach ($securityProfileUsers as $securityProfileUser) {
        //     //     echo $securityProfileUser->permissions;
        //     //     echo "<br>";
        //     //     echo $securityProfileUser->user->name;
        //     //     echo "<br>";
        //     //     echo $securityProfileUser->user->email;
        //     //     echo "<br>";
        //     // }

        //     // echo "<br>";
        //     // echo "<br>";

        //     // echo count($securityProfileUsers->pluck('user'));
        //     // echo "<br>";
        //     // echo count($securityProfileUsers);

        //     if (empty($securityProfile)) {
        //         abort(403, 'Unauthorized action.');
        //     } else {
        //         return view('pages.editSecurityProfile')->with(['securityProfile'=>$securityProfile, 'securityProfileUsers'=>$securityProfileUsers]);
        //     }
        // } else {
        //     return redirect('/dashboard')->with('error', "Please ensure that your code is linked to a secuirty profile before editing permissions");
        // }

        
    }

    public function create() 
    {
        $authId = auth()->user()->id;

        $securityProfile = new SecurityProfiles;
        $securityProfile->created_at = NOW();
        $securityProfile->updated_at = NOW();
        $securityProfile->profile_type = "priv";
        $securityProfile->profile_name = "Unnamed Security Profile";
        $securityProfile->user_id = $authId;
        $securityProfile->save();

        return view('pages.editSecurityProfile')->with(['securityProfile'=>$securityProfile, 'headerType'=>"New Security Profile"]);
    }

    // public function create(Request $request)
    // {
    //     $validated = $request->validate([
    //         'securityProfileName' => 'required',
    //         'profileType' => 'nullable|string',
    //         'userCount' => 'required'
    //     ]);

    //     $userCount = $request->input('userCount');

    //     echo $userCount;
    //     echo "<br>";

    //     // Check optional filled to make profile public
    //     if (!$request->has('profileType')) {
    //         $profileType = 'priv';
    //     } else {
    //         $profileType = $request->input('profileType');
    //     }

    //     echo $profileType;
    //     echo "<br>";

        

    //     for ($i=0; $i <= $userCount ; $i++) { 
    //         if ($request->filled('addUserEmail'.$i) || $request->filled('addUserName'.$i)) {
    //             $request->validate([
    //                 'addUserEmail'.$i => 'required|email',
    //                 'addUserName'.$i => 'required',
    //                 'addUserPermissions'.$i => 'required'
    //             ],
    //             [
    //                 'addUserEmail'.$i.'.required' => 'An Email is Required on Row '.($i+1),
    //                 'addUserEmail'.$i.'.email' => 'Please Enter a Valid Email on Row '.($i+1),
    //                 'addUserName'.$i.'.required' => 'A Name is Required on Row '.($i+1),
    //                 'addUserPermissions'.$i.'.required' => 'Please Select Appropriate Permissions on Row '.($i+1)
    //             ]);

    //             if ($request->input('addUserPermissions'.$i) == "view") {
    //                 $permissions = 1;
    //             } elseif ($request->input('addUserPermissions'.$i) == "update") {
    //                 $permissions = 2;
    //             } elseif ($request->input('addUserPermissions'.$i) == "full") {
    //                 $permissions = 3;
    //             }

    //             try {
    //                 $SPUserId = User::where([
    //                                 'email' => $request->input('addUserEmail'.$i), 
    //                                 'name' => $request->input('addUserName'.$i) 
    //                             ])->first('id')->id;
    //             } catch (\Throwable $th) {
    //                 return redirect('/securityProfilePage/'.$secProfileId.'/editSecurityProfile')->with('error', $request->input('addUserName'.$i).' is not a registered user');
    //             }

    //             $securityProfileUsers = new SecurityProfileUsers;
    //             $securityProfileUsers->created_at = NOW();
    //             $securityProfileUsers->updated_at = NOW();
    //             $securityProfileUsers->security_profile_id = $secProfileId;
    //             $securityProfileUsers->user_id = $SPUserId;
    //             $securityProfileUsers->invitee_id = 0;
    //             $securityProfileUsers->permissions = $permissions;
    //             $securityProfileUsers->save();
    //         }   
    //     }
    // }

    public function edit(Request $request, SecurityProfiles $secProfile)
    {
        $this->authorize('editSecurityProfile', $secProfile);

        $validated = $request->validate([
            'securityProfileName' => 'required',
            'profileType' => 'nullable|string',
            'userCount' => 'required'
        ]);

        $userCount = $request->input('userCount');
        $DBspUsersCount = $request->input('DBspUsersCount');
        $DBspUsersCountRemaining = $request->input('DBspUsersCountRemaining');

        // echo "Total: ".$userCount;
        // echo "<br>";
        // echo "DB Count: ".$DBspUsersCount;
        // echo "<br>";
        // echo "Remaining: ".$DBspUsersCountRemaining;
        // echo "<br>";   
        // echo "<br>";     

        // Check optional filled to make profile public
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

                $SPUser = User::where([
                                        'email' => $request->input('addUserEmail'.$i), 
                                        'name' => $request->input('addUserName'.$i) 
                                    ])->first();

                // Have to query each time because values are being updated
                $secProfile = SecurityProfiles::find($secProfile->id);

                if ($SPUser == NULL) {
                    return redirect('/securityProfilePage/'.$secProfile -> id.'/editSecurityProfile')->with('error', $request->input('addUserName'.$i).' is not a registered user. Please make sure you have provided the right combination of the name and email fileds');
                } elseif ($SPUser->can('checkDuplicateUser', $secProfile->security_profile_users)) {
                    return redirect('/securityProfilePage/'.$secProfile -> id.'/editSecurityProfile')->with('error', $request->input('addUserName'.$i).' is already added to this security profile');
                } else {

                    if ($request->input('addUserPermissions'.$i) == "view") {
                        $permissions = 1;
                    } elseif ($request->input('addUserPermissions'.$i) == "update") {
                        $permissions = 2;
                    } elseif ($request->input('addUserPermissions'.$i) == "full") {
                        $permissions = 3;
                    }

                    $securityProfileUsers = new SecurityProfileUsers;
                    $securityProfileUsers->created_at = NOW();
                    $securityProfileUsers->updated_at = NOW();
                    $securityProfileUsers->security_profile_id = $secProfile -> id;
                    $securityProfileUsers->user_id = $SPUser -> id;
                    $securityProfileUsers->invitee_id = 0;
                    $securityProfileUsers->permissions = $permissions;
                    $securityProfileUsers->save();
                }
                

                // echo $request->input('addUserEmail'.$i);
                // echo "<br>";
                // echo $request->input('addUserName'.$i);
                // echo "<br>";
                // echo $request->input('addUserPermissions'.$i);
                // echo "<br>";

                

                // try {
                //     $SPUserId = User::where([
                //                     'email' => $request->input('addUserEmail'.$i), 
                //                     'name' => $request->input('addUserName'.$i) 
                //                 ])->first('id')->id;
                // } catch (\Throwable $th) {
                //     return redirect('/securityProfilePage/'.$secProfile -> id.'/editSecurityProfile')->with('error', $request->input('addUserName'.$i).' is not a registered user');
                // }

                // echo $permissions;
                // echo "<br>";
                // echo "Security Profile User Id: ".$SPUserId;
                // echo "<br>";

                

                // Dont Need For now - for if user doesn't have a registered account 
                    // echo "Security Profile Id: ".$secProfileId;
                    // echo "<br>";

                    // $SPPageIds = SecurityProfiles::find($secProfileId)->pages;

                    // echo "Security Profile Page Id: ".$SPPageIds;
                    // echo "<br>";
                    // echo "<br>";

                    // foreach ($SPPageIds as $SPPageId) {
                    //     $pageUsers = new PageUsers;
                    //     $pageUsers->created_at = NOW();
                    //     $pageUsers->updated_at = NOW();
                    //     $pageUsers->user_id = $SPUserId;
                    //     $pageUsers->page_id = $SPPageId->id;
                    //     $pageUsers->permissions = $permissions;
                    //     $pageUsers->invitee_id = 0;
                    //     $pageUsers->user_type = 'spu';
                    //     $pageUsers->save();
                    // }
            }
        }


        // Don't Need for Now - for if user doesn't have a registered account 
            // $pageUsers = PageUsers::whereHas('pages', function($q) use($secProfileId){
            //                         $q->where('security_profile_id', $secProfileId);
            //                     })->get();

            // $SPPageIds = SecurityProfiles::find($secProfileId)->pages;

            // echo $pageUsers;
                            
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

                $SPUserUpdate = User::where([
                                    'email' => $request->input('addUserEmailUpdate'.$j), 
                                    'name' => $request->input('addUserNameUpdate'.$j) 
                                ])->first();

                // Have to query each time because values are being updated
                $secProfile = SecurityProfiles::find($secProfile->id);

                if ($SPUserUpdate == NULL) {
                    return redirect('/securityProfilePage/'.$secProfile -> id.'/editSecurityProfile')->with('error', $request->input('addUserNameUpdate'.$j).' is not a registered user. Please make sure you have provided the right combination of the name and email fileds');
                } elseif ($SPUserUpdate->can('checkDuplicateUser', $secProfile->security_profile_users->take($j))) { // Check against user input values

                    // Check against original database values
                    if ($secProfile->security_profile_users[$j]->user->can('checkDuplicateUser', $secProfile->security_profile_users->take($j))) {
                        SecurityProfileUsers::find($secProfile->security_profile_users[$j]->id)->delete();
                    }
                    
                    return redirect('/securityProfilePage/'.$secProfile -> id.'/editSecurityProfile')->with('error', $request->input('addUserNameUpdate'.$j).' is already added to this security profile');
                } else {

                    if ($request->input('addUserPermissionsUpdate'.$j) == "view") {
                        $permissionsUpdate = 1;
                    } elseif ($request->input('addUserPermissionsUpdate'.$j) == "update") {
                        $permissionsUpdate = 2;
                    } elseif ($request->input('addUserPermissionsUpdate'.$j) == "full") {
                        $permissionsUpdate = 3;
                    }

                    $securityProfileUsers = SecurityProfileUsers::find($request->input('securityProfileUserId'.$j));
                    $securityProfileUsers->updated_at = NOW();
                    $securityProfileUsers->user_id = $SPUserUpdate -> id;
                    $securityProfileUsers->permissions = $permissionsUpdate;
                    $securityProfileUsers->save();
                }

            } else {
                $securityProfileUsers = SecurityProfileUsers::find($request->input('securityProfileUserId'.$j))->delete();
            }
        }

        $secProfile->updated_at = NOW();
        $secProfile->profile_type = $profileType;
        $secProfile->profile_name = $request->input('securityProfileName');
        $secProfile->save();

        return redirect('/securityProfilePage')->with('success', $secProfile->profile_name.': Security Profile Updated Successfully');

    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'delete' => 'required'
        ]);

        $securityProfile = SecurityProfiles::find($request->input('delete'))->delete();
        $securityProfileUser = SecurityProfileUsers::where('security_profile_id', $request->input('delete'))->delete();

        $pages = Pages::where('security_profile_id', $request->input('delete'))->get();

        foreach ($pages as $page) {
            $page->security_profile_id = NULL;
            $page->save();
        }

        return redirect('/securityProfilePage')->with('success', "Security Profile Deleted Successfully");
    }
}
