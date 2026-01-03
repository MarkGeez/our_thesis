<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'firstName',
    'middleName',
    'lastName',
    'email',
    'password',
    'contactNumber',
    'birthday',
    'proofOfIdentity',
    'role',
    'registrationDate',
    'status'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    
    public function announcements(): HasMany{
        return $this->hasMany(Announcement::class);
    }

    public function complaints():HasMany{
        return $this->hasMany(Complaints::class, 'complainant_id');
    }

   
    public function feedbacks():HasMany{
        return $this->hasMany(Feedbacks::class);
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function blottersPlaintiff():HasMany{
        return $this->hasMany(Blotter::class, 'plaintiffId');
    }
    public function blottersEncoder():HasMany{
        return $this->hasMany(Blotter::class, 'encodedBy');
    }

    public function resident():HasOne{
        return $this->hasOne(Resident::class);
    }
   
}
