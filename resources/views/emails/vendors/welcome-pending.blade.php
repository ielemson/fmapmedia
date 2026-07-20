<x-mail::message>
# Welcome to FMAP Media, {{ $user->first_name }}

Thank you for registering for the **FMAP Media Vendor Programme**.

Your vendor application for **{{ $vendor->business_name }}** has been received successfully.

<x-mail::panel>
Your application status is currently:

**Pending Verification**
</x-mail::panel>

Our administration team will review the information you submitted. Please wait for your application to be approved.

Once your application is approved, you will receive another notification and will be able to access the complete vendor dashboard, including:

- Product referral links
- Sales information
- Commission records
- Withdrawal services
- Marketing materials
- Vendor support

No additional registration is required at this stage.

For assistance, contact us at [info@fmapmedia.com](mailto:info@fmapmedia.com).

Thanks,<br>
The {{ config('app.name', 'FMAP Media') }} Team
</x-mail::message>