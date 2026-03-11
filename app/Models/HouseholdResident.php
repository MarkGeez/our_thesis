<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseholdResident extends Model
{
    protected $table = 'household_resident';
    protected $fillable = ['household_id', 'resident_id', 'is_household_head'];
    protected $casts = [
        'is_household_head' => 'boolean',
    ];

    public function resident()
    {
    return $this->belongsTo(Resident::class);
    }

    public function household()
    {
    return $this->belongsTo(Household::class);
    }

}
