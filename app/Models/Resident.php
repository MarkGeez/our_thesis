<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $table= 'residents';

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
    ];
    
    

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
