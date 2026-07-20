<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorWelcomePendingApprovalMail extends Mailable
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
            subject: 'Welcome to the FMAP Media Vendor Programme'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.vendors.welcome-pending'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}