<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidentHouse extends Pivot
{
    protected $table = 'resident_house';

    protected $fillable = ['resident_id', 'house_id', 'role', 'is_primary'];
}
