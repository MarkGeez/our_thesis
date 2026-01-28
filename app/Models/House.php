<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = [
        'street_id', 'house_no', 'property_type'
    ];

    // Each house belongs to a street
    public function street()
    {
        return $this->belongsTo(Street::class);
    }

    // House has many households
    public function households()
    {
        return $this->hasMany(Household::class);
    }

    // House may have many residents via pivot
    public function residents()
    {
        return $this->belongsToMany(Resident::class, 'resident_house')
                    ->withPivot(['role', 'is_primary'])
                    ->withTimestamps();
    }
}
