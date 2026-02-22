<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaints extends Model
    protected static function booted()
    {
        static::created(function ($complaint) {
            ActiveLogger::log(
                'Complaints',
                'created',
                $complaint->id,
                'Created a new complaint record'
            );
        });

        static::updated(function ($complaint) {
            ActiveLogger::log(
                'Complaints',
                'updated',
                $complaint->id,
                'Updated a complaint record'
            );
        });

        static::deleted(function ($complaint) {
            ActiveLogger::log(
                'Complaints',
                'deleted',
                $complaint->id,
                'Deleted a complaint record'
            );
        });
    }
{
    protected $fillable = [
         "complainant_id",   
    "respondent_id",
    "complainantName",
    "address",
    "details",
    "remarks",
    "status"
    ];

    public function complainant(): BelongsTo{
        return $this->belongsTo(User::class, "complainant_id");
    }

    public function respondent(): BelongsTo{
        return $this->belongsTo(User::class, "respondent_id");

    }


}
