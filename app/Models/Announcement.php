<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\ActiveLogger;
use App\Models\Concerns\HasFormattedPublicId;

class Announcement extends Model
{
    use HasFactory;
    use HasFormattedPublicId;
    

    protected $fillable = ['title', 'image', 'details',
    'eventTime', 'eventEnd', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected $appends = [
        'formatted_id',
    ];

    public function getFormattedIdAttribute(): string
    {
        return $this->buildFormattedPublicId('ANNC');
    }

  protected static function booted()
    {
    static::created(function ($announcement) {
        ActiveLogger::log(
            'Announcement',
            'created',
            $announcement->id,
            'Created a new announcement'
        );
    });

    static::updated(function ($announcement) {
        ActiveLogger::log(
            'Announcement',
            'updated',
            $announcement->id,
            'Updated an announcement'
        );
    });
    

    static::deleted(function($announcement){
        ActiveLogger::log('Announcement', 'archived', $announcement->id, 'Archived an announcement');
    });
    
    }
}
