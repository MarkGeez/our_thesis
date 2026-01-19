<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpdateBlotter extends Model
{
   protected $fillable = [
    'remarks',
    'status',
    'photo_path',
    'date'
   ];

   public function blotter():BelongsTo{
      return $this->belongsTo(Blotter::class);
   }





}
