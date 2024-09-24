<?php

namespace App\Mail;

use Botble\ACL\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscribedSuccessfullyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscribed Successfully',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscribed-successfully',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
