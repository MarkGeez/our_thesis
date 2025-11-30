<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    

    protected $fillable = ['title', 'image', 'details', 
    'eventTime', 'eventEnd', 'postedAt', 'user_id'];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
