<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Feedbacks extends Model
{
    protected $fillable= [
        "message",
        "user_id"
    ];
    public function feedback(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    
}
