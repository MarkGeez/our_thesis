<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaints extends Model
{
    protected $fillable = [
         "complainant_id",   
    "respondent_id",
    "complainantName",
    "address",
    "details",
    "remarks",
    "status"
    ];

    public function complainant(): BelongsTo{
        return $this->belongsTo(User::class, "complainant_id");

    }

    public function respondent(): BelongsTo{
        return $this->belongsTo(User::class, "respondent_id");

    }


}
