<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CertificateRequest extends Model
{
    public function certificate():BelongsTo{
        return $this->belongsTo(Certificate::class, "certificate_id", "id");
    }
}


