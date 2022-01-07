<?php

namespace App\Policies;

use Auth;
use App\User;
use App\SecurityProfiles;
use App\Codes;
use Illuminate\Auth\Access\HandlesAuthorization;

class SecurityProfilesPolicy
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

    public function create(User $user)
    {
        return $user->id === Auth::user()->id;
    }

    public function edit(User $user, SecurityProfiles $securityProfile)
    {
        return $user->id === $securityProfile->user_id;
    }

    public function delete(User $user, SecurityProfiles $securityProfile)
    {
        return $user->id === $securityProfile->user_id;
    }

    public function editSubs(User $user, Codes $code)
    {
        foreach ($code->securityProfiles as $securityProfile) {
            foreach ($securityProfile->security_profile_users as $securityProfileUser) {
                if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 2) {
                    return true;
                }
            }
        }

        return false;
    }
}
