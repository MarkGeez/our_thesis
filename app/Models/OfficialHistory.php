<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficialHistory extends Model
{
    protected $fillable = [
        'official_id',
        'resident_id',
        'position',
        'details',
        'start',
        'end',
        'action',
        'changed_by',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}
