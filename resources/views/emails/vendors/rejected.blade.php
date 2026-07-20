<x-mail::message>

# Vendor Application Update

Dear {{ $vendor->user->first_name }},

Thank you for your interest in becoming a vendor on the FMAP Media platform.

After reviewing your application for:

### {{ $vendor->business_name }}

we regret to inform you that your application was **not approved at this time**.

@if(!empty($reason))

## Reason for the decision

> {{ $reason }}

@endif

This decision does not permanently prevent you from applying again in the future.

If you believe additional information may support your application, you may contact our support team for clarification or submit a fresh application when eligible.

<x-mail::button :url="route('contact')">
Contact Support
</x-mail::button>

Thank you for your interest in FMAP Media.

Regards,<br>
{{ config('app.name') }}

</x-mail::message>