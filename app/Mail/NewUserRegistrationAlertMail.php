<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserRegistrationAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        $fullName = trim(implode(' ', array_filter([
            $this->user->firstName,
            $this->user->middleName,
            $this->user->lastName,
        ])));

        return new Envelope(
            subject: 'New User Registration: ' . ($fullName !== '' ? $fullName : $this->user->email),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-user-registration-alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
