<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // FIXED: Added "Eloquent"

class Official extends Model
{
    protected $fillable = [
        'resident_id',     // You need this
        'position',        // Keep if you need
        'details',         // Keep if you need
        'start',           // Keep if you need
        'end'              // Keep if you need
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
    
   
}