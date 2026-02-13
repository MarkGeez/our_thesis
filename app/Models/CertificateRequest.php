<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateRequest extends Model
{
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

    public const TYPES = ['bonafide', 'indigency', 'soloparent', 'senior'];

    public const STATUSES = ['pending', 'approved', 'declined', 'picked_up'];

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
            return trim("{$this->resident->firstName} {$this->resident->middleName} {$this->resident->lastName}");
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