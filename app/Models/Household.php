<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasFormattedPublicId;

class Household extends Model
{
    use HasFormattedPublicId;

     protected $fillable = ['house_id'];

    protected $appends = [
        'formatted_id',
    ];

    public function getFormattedIdAttribute(): string
    {
        return $this->buildFormattedPublicId('HSHD');
    }

    // Household belongs to one house
    public function house()
    {
        return $this->belongsTo(House::class);
    }

    // Household has many residents
    public function residents()
    {
        return $this->belongsToMany(Resident::class, 'household_resident')
                    ->withPivot('is_household_head')
                    ->withTimestamps();
    }

    // Convenience method: get head of household
    public function head()
    {
        return $this->residents()->wherePivot('is_household_head', true)->first();
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }
}
