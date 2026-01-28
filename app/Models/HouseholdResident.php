<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseholdResident extends Pivot
{
    protected $table = 'household_resident';
    protected $fillable = ['household_id', 'resident_id', 'is_household_head'];
}
