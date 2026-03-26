<?php

namespace App\Mail;

use App\Models\Complaints;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Complaints $complaint)
    {
    }

    public function envelope(): Envelope
    {
        $statusLabel = match ($this->complaint->status) {
            'on-going' => 'On-going',
            'resolved' => 'Resolved',
            'rejected' => 'Rejected',
            default => ucfirst((string) $this->complaint->status),
        };

        return new Envelope(
            to: $this->complaint->complainant?->email,
            subject: "Complaint Status Update: {$statusLabel}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.complaint-status-update',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
