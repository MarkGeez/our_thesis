<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'service_type_id',
        'user_id',
        'purpose',
        'status',
        'request_schedule',
        'returned_at',
        'quantity_requested',
        'remarks',
    ];

    /**
     * The service or equipment being requested.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_type_id')->withTrashed();
    }

    /**
     * The user who made the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
