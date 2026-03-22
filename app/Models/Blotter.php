<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\ActiveLogger;
use App\Models\Concerns\HasFormattedPublicId;

class Blotter extends Model
    
{
    use HasFormattedPublicId;

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
    'incident_date_time',
    'blotter_type',
    'schedule',
    'encodedBy',
    'action',
    'status',
    'statusDescription',
    'current_status'
    ];

    protected $casts = [
        'is_finished' => 'boolean',
        'incident_date_time' => 'datetime',
    ];

    protected $appends = [
        'formatted_id',
        'formatted_blotter_number',
    ];

   public function isFinished(): bool {
      return $this->is_finished === true;
   }

    public function getFormattedBlotterNumberAttribute(): string
    {
        return $this->buildFormattedPublicId('BLTR');
    }

    public function getFormattedIdAttribute(): string
    {
        return $this->getFormattedBlotterNumberAttribute();
    }

    // App\Models\Blotter.php
public function updates(): HasMany
{
    return $this->hasMany(UpdateBlotter::class, 'blotter_id');
}

// Then update line 87 in your controller to keep using $blotter->updates

    protected static function booted()
    {
        static::created(function ($blotter) {
            ActiveLogger::log(
                'Blotter',
                'created',
                $blotter->id,
                'Created a new blotter record'
            );
        });

        static::updated(function ($blotter) {
            ActiveLogger::log(
                'Blotter',
                'updated',
                $blotter->id,
                'Updated a blotter record'
            );
        });

        static::deleted(function ($blotter) {
            ActiveLogger::log(
                'Blotter',
                'deleted',
                $blotter->id,
                'Deleted a blotter record'
            );
        });
    }
    
}
