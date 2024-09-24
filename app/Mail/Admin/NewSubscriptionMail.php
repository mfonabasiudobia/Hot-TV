<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Subscription',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new-subscription',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
