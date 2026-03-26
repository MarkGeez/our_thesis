<?php

namespace App\Mail;

use App\Models\Complaints;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewComplaintAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Complaints $complaint)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Complaint Entry: ' . $this->complaint->formatted_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-complaint-alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
