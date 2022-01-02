<?php

namespace App\Policies;

use App\User;
use App\SecurityProfiles;
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

    public function edit(User $user, SecurityProfiles $securityProfile)
    {
        return $user->id === $securityProfile->user_id;
    }
}
