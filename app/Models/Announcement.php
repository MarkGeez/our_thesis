<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\ActiveLogger;

class Announcement extends Model
{
    

    protected $fillable = ['title', 'image', 'details', 
    'eventTime', 'eventEnd', 'postedAt', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    use HasFactory;

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
