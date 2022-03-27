<?php

namespace App\Policies;

use Auth;
use App\User;
use App\SecurityProfiles;
use App\Codes;
use App\Pages;
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
}
