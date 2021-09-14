<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageTexts extends Model
{
    public function pages() {
        return $this->belongsTo(Pages::class, 'page_id', 'id');
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
