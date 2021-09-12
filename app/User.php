<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function codes(){
        return $this->hasMany(Codes::class);
    }

    public function pages() {
        return $this->hasManyThrough(Pages::class, Codes::class, 'user_id', 'code_id', 'id', 'id');
    }

    public function securityProfiles() {
        return $this->hasMany(SecurityProfiles::class);
    }

    public function page_users() {
        return $this->hasMany(PageUsers::class);
    }

    public function page_files() {
        return $this->hasMany(PageFiles::class);
    }
}
