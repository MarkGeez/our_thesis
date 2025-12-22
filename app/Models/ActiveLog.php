<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveLog extends Model
{
    protected $fillable= [
        'user_id',
        'action',
        'module',
        'record_id',
        'description',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
