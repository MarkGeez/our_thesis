<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
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