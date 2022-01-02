<?php

namespace App\Policies;

use App\User;
use App\SecurityProfileUsers;
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
}
