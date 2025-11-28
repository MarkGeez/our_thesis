<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = 'positions';

    /**
     * Indicates if the model should be timestamped.
     * FIX: Set to false because the positions migration does not include timestamps.
     *
     * @var bool
     */
    protected $fillable = [
        "positionName"
    ];
    use HasFactory;
}
