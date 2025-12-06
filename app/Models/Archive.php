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
}
