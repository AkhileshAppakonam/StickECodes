<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageUsers extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pages() {
        return $this->belongsTo(Pages::class);
    }
}
