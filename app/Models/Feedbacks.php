<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\HasFormattedPublicId;


class Feedbacks extends Model
{
    use HasFormattedPublicId;

    protected $fillable= [
        "message",
        "user_id"
    ];

    protected $appends = [
        'formatted_id',
    ];

    public function getFormattedIdAttribute(): string
    {
        return $this->buildFormattedPublicId('FDBK');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
