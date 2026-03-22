<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasFormattedPublicId;

class ActiveLog extends Model
{
    use HasFormattedPublicId;

    protected $fillable= [
        'user_id',
        'action',
        'module',
        'record_id',
        'description',
    ];

    protected $appends = [
        'formatted_id',
    ];

    public function getFormattedIdAttribute(): string
    {
        return $this->buildFormattedPublicId('ACTL');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
