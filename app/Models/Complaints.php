<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// Import ActiveLogger if needed.
// use App\Services\ActiveLogger;

class Complaints extends Model
{
    protected $fillable = [
        'complainant_id',
        'respondent_id',
        'complainantName',
        'address',
        'details',
        'remarks',
        'status',
    ];

    protected static function booted()
    {
        static::created(function (self $complaint) {
            if (class_exists(\ActiveLogger::class)) {
                \ActiveLogger::log(
                    'Complaints',
                    'created',
                    $complaint->id,
                    'Created a new complaint record'
                );
            }
        });

        static::updated(function (self $complaint) {
            if (class_exists(\ActiveLogger::class)) {
                \ActiveLogger::log(
                    'Complaints',
                    'updated',
                    $complaint->id,
                    'Updated a complaint record'
                );
            }
        });

        static::deleted(function (self $complaint) {
            if (class_exists(\ActiveLogger::class)) {
                \ActiveLogger::log(
                    'Complaints',
                    'deleted',
                    $complaint->id,
                    'Deleted a complaint record'
                );
            }
        });
    }

    public function complainant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'complainant_id');
    }

    public function respondent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'respondent_id');
    }
}