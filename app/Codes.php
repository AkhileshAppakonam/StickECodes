<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codes extends Model
{
    // Fields not mass-assignable
    protected $guarded = [];
    
    // Table Name
    protected $table = 'codes';
    // Primary Key
    protected $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
