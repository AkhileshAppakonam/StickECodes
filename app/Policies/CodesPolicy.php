<?php

namespace App\Policies;

use Auth;
use App\User;
use App\Codes;
use App\Pages;
use App\PageFiles;
use Illuminate\Auth\Access\HandlesAuthorization;

class CodesPolicy
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

    public function master(User $user, Codes $code)
    {
        return $user->id === $code->user_id;
    }

    public function edit(User $user, Codes $code)
    {
        foreach ($code->securityProfiles as $securityProfile) {
            foreach ($securityProfile->security_profile_users as $securityProfileUser) {
                if ($user->id === $securityProfileUser->user_id && $securityProfileUser->permissions > 1) {
                    return true;
                }
            }
        }
    }

    public function pageFile(User $user, PageFiles $file)
    {
        return $user->id === $file->user_id;
    }
}
