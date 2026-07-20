<x-mail::message>

# Vendor Application Under Review

Dear {{ $vendor->user->first_name }},

Your vendor account for:

### {{ $vendor->business_name }}

has been returned to **Pending Review** status.

This means your application is currently undergoing further administrative review and verification.

During this review period, vendor access and promotional activities remain temporarily unavailable.

You will receive another email once a final decision has been made regarding your application.

Thank you for your patience and understanding.

Regards,<br>
{{ config('app.name') }}

</x-mail::message>