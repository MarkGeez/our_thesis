<?php

namespace App\Mail;

use App\Models\CertificateRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CertificateRequest $certificateRequest)
    {
    }

    public function envelope(): Envelope
    {
        $statusLabel = match ($this->certificateRequest->status) {
            'approved' => 'Approved for Pickup',
            'declined' => 'Rejected',
            default => ucfirst((string) $this->certificateRequest->status),
        };

        return new Envelope(
            to: $this->certificateRequest->user?->email,
            subject: "Certificate Request Status: {$statusLabel}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate-status-update',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
