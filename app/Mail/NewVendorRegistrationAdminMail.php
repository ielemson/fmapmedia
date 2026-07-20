<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewVendorRegistrationAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Vendor $vendor
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Vendor Registration Awaiting Verification'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.vendors.admin-registration'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}