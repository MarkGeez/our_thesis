<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $table = 'family_members';

    protected $fillable = [
        'household_id',
        'resident_id',
        'encoded_by',
        'relationship'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'encoded_by');
    }

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}

