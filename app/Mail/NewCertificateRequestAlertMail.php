<?php

namespace App\Mail;

use App\Models\CertificateRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCertificateRequestAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CertificateRequest $certificateRequest)
    {
    }

    public function envelope(): Envelope
    {
        $certificateType = ucfirst((string) $this->certificateRequest->certificate_type);

        return new Envelope(
            subject: "New Certificate Request: {$certificateType}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-certificate-request-alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
