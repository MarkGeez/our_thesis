<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
    protected static function booted()
    {
        static::created(function ($certificate) {
            ActiveLogger::log(
                'Certificate',
                'created',
                $certificate->id,
                'Created a new certificate record'
            );
        });

        static::updated(function ($certificate) {
            ActiveLogger::log(
                'Certificate',
                'updated',
                $certificate->id,
                'Updated a certificate record'
            );
        });

        static::deleted(function ($certificate) {
            ActiveLogger::log(
                'Certificate',
                'deleted',
                $certificate->id,
                'Deleted a certificate record'
            );
        });
    }
{
    //
}
