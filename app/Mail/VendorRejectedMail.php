<?php

namespace App\Mail;

use App\Models\Vendor;
use Illuminate\Mail\Mailable;

class VendorRejectedMail extends Mailable
{
    public Vendor $vendor;

    public ?string $reason;

    public function __construct(
        Vendor $vendor,
        ?string $reason = null
    ) {
        $this->vendor = $vendor;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this
            ->subject('Vendor Application Update')
            ->markdown('emails.vendors.rejected');
    }
}