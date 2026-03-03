<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserAccountStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        $statusLabel = match ($this->user->status) {
            'approved' => 'Approved',
            'declined', 'rejected' => 'Rejected',
            default => ucfirst((string) $this->user->status),
        };

        return new Envelope(
            to: $this->user->email,
            subject: "Account Status Update: {$statusLabel}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-account-status-update',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
