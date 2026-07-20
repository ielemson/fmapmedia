<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Contact-form information.
     */
    public function __construct(
        public array $contact
    ) {
    }

    /**
     * Define the email envelope.
     */
    public function envelope(): Envelope
    {
        $fullName = trim(
            ($this->contact['first_name'] ?? '') . ' ' .
            ($this->contact['last_name'] ?? '')
        );

        return new Envelope(
            subject: 'FMAP Media Contact: ' . $this->contact['subject'],

            replyTo: [
                new Address(
                    $this->contact['email'],
                    $fullName
                ),
            ],
        );
    }

    /**
     * Define the email content.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-message',
            with: [
                'contact' => $this->contact,
            ],
        );
    }

    /**
     * Define attachments.
     */
    public function attachments(): array
    {
        return [];
    }
}