<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\URL;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail; 

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
    'user_id',
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
    'status',
    'profile_image'

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
    
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'encoded_by');
    }


    
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

  
    public function blotters():HasMany{
        return $this->hasMany(Blotter::class, 'updated_by');
    }

    public function resident():HasOne{
        return $this->hasOne(Resident::class, 'user_id');
    }

    public function certificateRequests(): HasMany
    {
        return $this->hasMany(CertificateRequest::class, 'user_id');
    }

    /**
     * Send the password reset notification via email.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $resetUrl = URL::temporarySignedRoute('password.reset', now()->addMinutes(60), ['token' => $token]);
        
        Mail::send(new PasswordResetMail($this, $resetUrl));
    }
   
}

