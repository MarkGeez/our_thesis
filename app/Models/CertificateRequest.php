<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\ActiveLogger;
use App\Models\Concerns\HasFormattedPublicId;

class CertificateRequest extends Model
{
    use HasFormattedPublicId;

    protected $table = 'certificate_requests';

    protected $fillable = [
        'user_id',
        'resident_id',
        'certificate_type',
        'purpose',
        'address',
        'request_data',
        'status',
        'decline_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'request_data' => 'array',
        'approved_at' => 'datetime',
    ];

    protected $appends = [
        'formatted_id',
    ];

    public function getFormattedIdAttribute(): string
    {
        return $this->buildFormattedPublicId('CERT');
    }

    public const TYPES = ['bonafide', 'indigency', 'soloparent', 'senior'];

    public const STATUSES = ['pending', 'approved', 'declined', 'picked_up'];

    protected static function booted()
    {
        static::created(function ($certificate) {
            ActiveLogger::log(
                'Certificate',
                'created',
                $certificate->id,
                'Created a new certificate'
            );
        });

        static::updated(function ($certificate) {
            // Only log as 'updated' if not status change to 'picked_up' (print) or 'approved' (generate)
            if ($certificate->isDirty('status')) {
                if ($certificate->status === 'picked_up') {
                    ActiveLogger::log(
                        'Certificate',
                        'printed',
                        $certificate->id,
                        'Printed a certificate'
                    );
                } elseif ($certificate->status === 'approved') {
                    ActiveLogger::log(
                        'Certificate',
                        'generated',
                        $certificate->id,
                        'Generated a certificate'
                    );
                } else {
                    ActiveLogger::log(
                        'Certificate',
                        'updated',
                        $certificate->id,
                        'Updated a certificate'
                    );
                }
            } else {
                ActiveLogger::log(
                    'Certificate',
                    'updated',
                    $certificate->id,
                    'Updated a certificate'
                );
            }
        });

        static::deleted(function($certificate){
            ActiveLogger::log('Certificate', 'archived', $certificate->id, 'Archived a certificate');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'resident_id', 'id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function getRequesterNameAttribute(): string
    {
        if ($this->resident) {
            return trim(
                "{$this->resident->firstName} {$this->resident->middleName} {$this->resident->lastName}"
            );
        }

        $u = $this->user;

        return trim("{$u->firstName} {$u->middleName} {$u->lastName}");
    }

    public function getRequesterAddressAttribute(): string
    {
        if ($this->resident) {
            return trim("{$this->resident->houseNo} {$this->resident->street}");
        }

        return $this->address
            ?? ($this->request_data['address'] ?? null)
            ?? ($this->request_data['postal_address'] ?? null)
            ?? 'N/A';
    }
}