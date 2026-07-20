<x-mail::message>

# New Vendor Registration

A new vendor application has been submitted on the **FMAP Media platform** and is awaiting verification and approval.

<x-mail::panel>

### Applicant Information

**Applicant Name:**  
{{ $user->first_name }} {{ $user->last_name }}

**Business Name:**  
{{ $vendor->business_name }}

**Email Address:**  
{{ $user->email }}

**Phone Number:**  
{{ $vendor->phone }}

**Vendor Type:**  
{{ $vendor->vendor_type }}

**Location:**  
{{ $vendor->city }}, {{ $vendor->state }}

@if($vendor->vendor_code)
**Vendor Code:**  
{{ $vendor->vendor_code }}
@endif

@if($vendor->referral_slug)
**Referral Slug:**  
{{ $vendor->referral_slug }}
@endif

**Application Status:**  
Pending Review

</x-mail::panel>

Kindly log in to the administration dashboard to review the application and take the appropriate action.

<x-mail::button :url="route('admin.vendors.show', $vendor)">
Review Vendor Application
</x-mail::button>

This application will remain pending until it is approved or rejected by an administrator.

Regards,<br>
**{{ config('app.name', 'FMAP Media') }}**

</x-mail::message>