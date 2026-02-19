<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class GeneratedReport extends Model
{
    // table name does not follow Laravel's pluralization for this model
    protected $table = 'reports';

    protected $fillable = [
        'report_name',
        'report_type',
        'filters_used',
        'generated_by',
        'total_records',
    ];

    // cast filters to array when retrieved
    protected $casts = [
        'filters_used' => 'array',
    ];

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
