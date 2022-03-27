<?php

namespace App\Policies;

use Auth;
use App\Codes;
use App\User;
use App\SecurityProfileUsers;
use App\SecurityProfiles;
Use App\Pages;
use Illuminate\Auth\Access\HandlesAuthorization;

class SecurityProfileUsersPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function duplicateUser(User $user, $securityProfileUsers)
    {
        foreach ($securityProfileUsers as $securityProfileUser) {
            if ($user->id === $securityProfileUser->user_id) {
                return true;
            }
        }
        
        return false;
    }

    // public function fullControl(User $user, Codes $code)
    // {
    //     foreach ($code->securityProfiles as $securityProfile) {
    //         foreach ($securityProfile->security_profile_users as $securityProfileUser) {
    //             if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 2) {
    //                 return true;
    //             }
    //         }
    //     }

    //     return false;
    // }

    // public function viewAndUpdate(User $user, Codes $code)
    // {
    //     foreach ($code->securityProfiles as $securityProfile) {
    //         foreach ($securityProfile->security_profile_users as $securityProfileUser) {
    //             if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 1) {
    //                 return true;
    //             }
    //         }
    //     }

    //     return false;
    // }

    // public function viewOnly(User $user, Codes $code)
    // {
    //     foreach ($code->securityProfiles as $securityProfile) {
    //         foreach ($securityProfile->security_profile_users as $securityProfileUser) {
    //             if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 0) {
    //                 return true;
    //             }
    //         }
    //     }

    //     return false;
    // }

    public function viewOnly(User $user, Pages $page)
    {
        foreach ($page->security_profile->security_profile_users as $securityProfileUser) {
            if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 0) {
                return true;
            }
        }
    }

    public function viewAndUpdate(User $user, Pages $page)
    {
        foreach ($page->security_profile->security_profile_users as $securityProfileUser) {
            if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 1) {
                return true;
            }
        }
    }

    public function fullControl(User $user, Pages $page)
    {
        foreach ($page->security_profile->security_profile_users as $securityProfileUser) {
            if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 2) {
                return true;
            }
        }
    }
}
