<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasFormattedPublicId;

class Archive extends Model
{
    use HasFormattedPublicId;

    protected $fillable = [
         'record_type',
        'record_id',
        'data',
        'archived_by',
        'reason',
    ];

    protected $casts = [
        "data" => "array"
    ];

    protected $appends = [
        'formatted_id',
    ];

    public function getFormattedIdAttribute(): string
    {
        return $this->buildFormattedPublicId('ARCH');
    }

    public function user(){
        return $this->belongsTo(User::class, 'archived_by');
    }
        protected static function booted()
        {
            static::created(function (self $archive) {
                if (class_exists(\App\Services\ActiveLogger::class)) {
                    \App\Services\ActiveLogger::log('Archives', 'created', $archive->id, 'Created a new archive record');
                }
            });
            static::updated(function (self $archive) {
                if (class_exists(\App\Services\ActiveLogger::class)) {
                    \App\Services\ActiveLogger::log('Archives', 'updated', $archive->id, 'Updated an archive record');
                }
            });
        }
}