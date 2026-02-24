<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
    use \App\Services\ActiveLogger;


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
    public function printReport()
    {
        // Add your report printing logic here
        ActiveLogger::log(
            'Reports',
            'printed',
            $this->id,
            'Printed a report'
        );
    }

    public function convertToPdf()
    {
        // Add your PDF conversion logic here
        ActiveLogger::log(
            'Reports',
            'converted_to_pdf',
            $this->id,
            'Converted report to PDF'
        );
    }
    
    protected static function booted()
    {
        static::created(function ($report) {
            ActiveLogger::log(
                'Reports',
                'created',
                $report->id,
                'Created a new report'
            );
        });
        static::updated(function ($report) {
            ActiveLogger::log(
                'Reports',
                'updated',
                $report->id,
                'Updated a report'
            );
        });
        static::deleted(function($report){
            ActiveLogger::log('Reports', 'archived', $report->id, 'Archived a report');
        });
    }
}
