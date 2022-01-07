<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codes extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pages() {
        return $this->hasMany(Pages::class, 'code_id', 'id');
	}

    public function securityProfiles() {
        return $this->belongsToMany(SecurityProfiles::class, 'pages', 'code_id', 'security_profile_id')->withPivot('page_title');
    }
}
