<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $table = 'family_members';

    protected $fillable = [
        'household_id',
        'encoded_by',
        'firstName',
        'middleName',
        'lastName',
        'birthdate',
        'sex',
        'relationship',
        'contactNumber',          
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'encoded_by');
    }

    public function household()
    {
        return $this->belongsTo(Household::class);
    }
}

