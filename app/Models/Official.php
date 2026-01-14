<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use HasFactory;
    
    protected $fillable =[
        'resident_id',
        'position_id', 
        'description'
    ];

    public function resident(){
        return $this->belongsTo(Resident::class, 'resident_id'); 
    }
    
    public function position(){
        return $this->belongsTo(Positions::class, 'position_id');
    }
}