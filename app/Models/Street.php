<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Street extends Model
{
    protected $fillable = ['street_name'];

     public function houses()
    {
        return $this->hasMany(House::class);
    }
}
