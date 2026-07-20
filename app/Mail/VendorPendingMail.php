<?php

namespace App\Mail;

use App\Models\Vendor;
use Illuminate\Mail\Mailable;

class VendorPendingMail extends Mailable
{
    public Vendor $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function build()
    {
        return $this
            ->subject('Vendor Application Returned To Review')
            ->markdown('emails.vendors.pending');
    }
}