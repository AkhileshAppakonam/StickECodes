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

    public function page_files() {
        return $this->hasMany(PageFiles::class, 'page_id', 'id');
    }

    public function page_urls(){
        return $this->hasMany(PageUrls::class, 'page_id', 'id');
    }
}
