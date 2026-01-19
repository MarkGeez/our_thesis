<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\ActiveLogger;

class Blotter extends Model
{

    protected $table = 'blotters';
    
    protected $fillable = [
    'plaintiffAddress',
    'plaintiffContactNumber',
    'plaintiffName',
    'plaintiffMiddleName',
    'plaintiffLastName',
    'plaintiffAge',
    'defendantAddress',
    'defendantContactNumber',
    'defendantName',
    'defendantMiddleName',
    'defendantLastName',
    'defendantAge',
    'witnessName',
    'witnessContactNumber',
    'proof',
    'blotterDescription',
    'schedule',
    'encodedBy',
    'action',
    'status',
    'statusDescription',
    ];

   

    public function updateBlotter():HasMany{
      return $this->HasMany(UpdateBlotter::class);
    }

    public static function booted(){
      static::created(function ($blotter) {
        ActiveLogger::log(
            'Announcement',
            'created',
            $blotter->id,
            'Created a new blotter record'
        );
    });

    }
    
}
