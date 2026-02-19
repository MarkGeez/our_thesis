<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\ActiveLogger;

class Blotter extends Model
{

    protected $table = 'blotters';
    
    protected $fillable = [
    'plaintiffAddress',
    'plaintiffContactNumber',
    'plaintiffName',
    'plaintiffMiddleName',
    'plaintiffLastName',
    'plaintiffAge',
    'defendantAddress',
    'defendantContactNumber',
    'defendantName',
    'defendantMiddleName',
    'defendantLastName',
    'defendantAge',
    'witnessName',
    'witnessContactNumber',
    'proof',
    'blotterDescription',
    'schedule',
    'encodedBy',
    'action',
    'status',
    'statusDescription',
    'current_status'
    ];

    protected $casts = [
        'is_finished' => 'boolean',
    ];

   public function isFinished(): bool {
      return $this->is_finished === true;
   }

    // App\Models\Blotter.php
public function updates(): HasMany
{
    return $this->hasMany(UpdateBlotter::class, 'blotter_id');
}

// Then update line 87 in your controller to keep using $blotter->updates

    public static function booted(){
      static::created(function ($blotter) {
        ActiveLogger::log(
            'Announcement',
            'created',
            $blotter->id,
            'Created a new blotter record'
        );
    });

    }
    
}
