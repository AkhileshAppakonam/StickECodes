<?php

namespace App\Policies;

use Auth;
use App\Codes;
use App\User;
use App\SecurityProfileUsers;
use App\SecurityProfiles;
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

    public function editPage(User $user, Codes $code)
    {
        foreach ($code->securityProfiles as $securityProfile) {
            foreach ($securityProfile->security_profile_users as $securityProfileUser) {
                if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 1) {
                    return true;
                }
            }
        }

        return false;
    }
}
