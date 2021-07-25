<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    public function code() {
    	return $this->belongsTo(Codes::class, 'code_id', 'id');
    }

    public function security_profile() {
        return $this->hasOne(SecurityProfiles::class, 'id', 'security_profile_id');
    }
}
