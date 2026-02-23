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
        protected static function booted()
        {
            static::created(function (self $official) {
                if (class_exists(\App\Services\ActiveLogger::class)) {
                    \App\Services\ActiveLogger::log('Officials', 'created', $official->id, 'Created a new official record');
                }
            });
            static::updated(function (self $official) {
                if (class_exists(\App\Services\ActiveLogger::class)) {
                    \App\Services\ActiveLogger::log('Officials', 'updated', $official->id, 'Updated an official record');
                }
            });
        }