<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    /** @use HasFactory<\Database\Factories\AnnouncementFactory> */

    protected $fillable = ['title', 'image', 'details', 
    'eventTime', 'eventEnd', 'postedAt', 'archiveTime'];
    use HasFactory;
}
