<x-mail::message>

# Vendor Account Suspended

Dear {{ $vendor->user->first_name }},

Your FMAP Media vendor account associated with:

### {{ $vendor->business_name }}

has been temporarily **suspended**.

During the suspension period, you will not be able to:

- Access vendor services
- Generate new referral sales
- Participate in promotional campaigns
- Request withdrawals

Existing earnings and records remain safely stored in your account.

If you believe this action was taken in error, please contact our support team for assistance.

<x-mail::button :url="route('contact-us')">
Contact Support
</x-mail::button>

Regards,<br>
{{ config('app.name') }}

</x-mail::message>