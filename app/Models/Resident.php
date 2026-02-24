<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    use App\Services\ActiveLogger;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'contactNo',
        'birthday',
        'emergencyContactNo',
        'emergencyContactName',
        'age',
        'sex',
        'parent',
        'enrolled',
        'educationalAttainment',
        'religion',
        'headOfFamily',
        'EncodedBy',
        'user_id',
        'image_path',
    ];

    protected static function booted()
    {
        static::created(function ($resident) {
            ActiveLogger::log(
                'Residents',
                'created',
                $resident->id,
                'Created a new resident'
            );
        });
        static::updated(function ($resident) {
            ActiveLogger::log(
                'Residents',
                'updated',
                $resident->id,
                'Updated a resident'
            );
        });
        static::deleted(function($resident){
            ActiveLogger::log('Residents', 'archived', $resident->id, 'Archived a resident');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function official()
    {
        return $this->hasOne(Official::class, 'resident_id');
    }

    public function houses()
    {
        return $this->belongsToMany(House::class, 'resident_house')
            ->withPivot(['role', 'is_primary'])
            ->withTimestamps();
    }

    public function households()
    {
        return $this->belongsToMany(Household::class, 'household_resident')
            ->withPivot('is_household_head')
            ->withTimestamps();
    }
}