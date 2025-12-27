<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    public function religion(){
        return $this->belongsTo(Religion::class, 'religionList');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
