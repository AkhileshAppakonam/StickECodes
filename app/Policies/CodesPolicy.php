<?php

namespace App\Policies;

use Auth;
use App\User;
use App\Codes;
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

    public function edit(User $user, Codes $code)
    {
        return $user->id === $code->user_id;
    }

    public function pageFile(User $user, PageFiles $file)
    {
        return $user->id === $file->user_id;
    }
}
