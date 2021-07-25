<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecurityProfiles extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pages() {
        return $this->hasMany(Pages::class, 'security_profile_id', 'id');
    }

    public function codes() {
        return $this->belongsToMany(Codes::class, 'pages', 'security_profile_id', 'code_id');
    }
}
