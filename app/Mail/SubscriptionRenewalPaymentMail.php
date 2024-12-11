<?php

namespace App\Mail;

use Botble\ACL\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionRenewalPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Renewal Payment',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-renewal-payment',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
