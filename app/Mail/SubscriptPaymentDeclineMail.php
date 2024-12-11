<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptPaymentDeclineMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscript Payment Decline',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscript-payment-decline',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
