<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Services\ActiveLogger;
use App\Models\Concerns\HasFormattedPublicId;

class Complaints extends Model
{
    use HasFormattedPublicId;

    protected $fillable = [
        'complainant_id',
        'respondent_id',
        'complainantName',
        'address',
        'details',
        'attachment_path',
        'complaint_datetime',
        'remarks',
        'status',
    ];

    protected $casts = [
        'complaint_datetime' => 'datetime',
    ];

    protected $appends = [
        'formatted_id',
    ];

    public function getFormattedIdAttribute(): string
    {
        return $this->buildFormattedPublicId('CMPL');
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        $path = trim((string) ($this->attachment_path ?? ''));
        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $normalizedPath = ltrim($path, '/');

        if (Str::startsWith($normalizedPath, 'public/')) {
            $normalizedPath = Str::after($normalizedPath, 'public/');
        }

        if (Str::startsWith($normalizedPath, 'storage/')) {
            $normalizedPath = Str::after($normalizedPath, 'storage/');
        }

        return asset('storage/' . ltrim($normalizedPath, '/'));
    }

    protected static function booted()
    {
        static::created(function ($complaint) {
            ActiveLogger::log(
                'Complaints',
                'created',
                $complaint->id,
                'Created a new complaint'
            );
        });

        static::updated(function ($complaint) {
            ActiveLogger::log(
                'Complaints',
                'updated',
                $complaint->id,
                'Updated a complaint'
            );
        });

        static::deleted(function($complaint){
            ActiveLogger::log('Complaints', 'archived', $complaint->id, 'Archived a complaint');
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