<?php

namespace App\Policies;

use App\User;
use App\Pages;
use App\Codes;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagesPolicy
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

    public function publicSP(User $user, Pages $page)
    {
        return $page->security_profile->profile_type == "gpub";
    }

    public function privateSP(User $user, Pages $page)
    {
        return $page->security_profile->profile_type == "priv";
    }

    public function master(User $user, Pages $page)
    {
        return $user->id === $page->code->user_id;
    }
}
