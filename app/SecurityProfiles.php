<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecurityProfiles extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function linkedCodes() {
        return $this->hasManyThrough(Codes::class, Pages::class, 'security_profile_id', 'user_id', 'id', 'code_id');
    }
}
