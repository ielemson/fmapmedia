<x-mail::message>

# Congratulations, {{ $vendor->user->first_name }}

Your vendor application for **{{ $vendor->business_name }}** has been approved by the **FMAP Media team**.

You can now begin using the vendor features available on the platform.

<x-mail::panel>

### Your Vendor Account

**Business Name:**  
{{ $vendor->business_name }}

**Vendor Code:**  
{{ $vendor->vendor_code }}

**Referral Slug:**  
{{ $vendor->referral_slug }}

**Status:**  
Approved

**Approved On:**  
{{ $vendor->approved_at?->format('d M Y, h:i A') }}

</x-mail::panel>

You can now:

- Access your vendor dashboard
- View available magazines
- Promote magazines using your referral links
- Track clicks, sales, and commissions
- Request withdrawals from approved earnings

<x-mail::button :url="route('dashboard')">
Go to Vendor Dashboard
</x-mail::button>

Keep your vendor code and account details secure. All referral activity and commissions earned through your account will be recorded in your dashboard.

Thank you for partnering with FMAP Media. We look forward to a successful relationship with you.

Regards,<br>
**{{ config('app.name', 'FMAP Media') }}**

</x-mail::message>