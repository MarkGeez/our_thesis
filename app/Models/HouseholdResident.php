<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HouseholdResident extends Pivot
{
    protected $table = 'household_resident';
    protected $fillable = ['household_id', 'resident_id', 'is_household_head'];
    protected $casts = [
        'is_household_head' => 'boolean',
    ];
}
