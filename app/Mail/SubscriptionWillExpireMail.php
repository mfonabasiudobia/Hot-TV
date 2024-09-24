<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionWillExpireMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Will Expire',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-will-expire',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
