<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecurityProfileUsers extends Model
{
    public function security_profile() {
    	return $this->belongsTo(SecurityProfiles::class, 'security_profile_id', 'id');
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }
}
