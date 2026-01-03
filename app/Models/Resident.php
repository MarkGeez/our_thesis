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
        'religionList',
        'headOfFamily',
        'EncodedBy',
    ];
    
    public function religion(){
    return $this->belongsTo(Religion::class, 'religionId'); // use the correct column
}


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
