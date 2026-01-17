<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'houseNo',
        'street',
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
        'image_path'
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function official(){
        return $this->hasOne(Official::class, 'resident_id'); 
    }
}