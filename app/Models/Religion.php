<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    public function residents(){
        return $this->hasMany(Resident::class);
    }
}
