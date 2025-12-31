<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'quantity',
        'description',
        'serviceAvailability',
        'image_path',
    ];

    /**
     * Service requests filed for this service/equipment.
     */
    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'service_type_id');
    }
}
