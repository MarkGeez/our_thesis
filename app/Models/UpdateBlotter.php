<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class UpdateBlotter extends Model
{
   protected $fillable = [
   'blotter_id',
    'remarks',
    'status',
    'photo_path',
    'date',
    'updated_by'
   ];

   public function blotter():BelongsTo{
      return $this->belongsTo(Blotter::class);
   }

   public function updater(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }





}
