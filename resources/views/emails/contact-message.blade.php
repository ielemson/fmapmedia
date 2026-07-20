<x-mail::message>
# New Contact Message

A new enquiry has been submitted through the FMAP Media website.

<x-mail::panel>
**Subject:** {{ $contact['subject'] ?? 'No subject provided' }}
</x-mail::panel>

## Sender Information

**Name:**  
{{ $contact['first_name'] ?? '' }} {{ $contact['last_name'] ?? '' }}

**Email Address:**  
[{{ $contact['email'] ?? '' }}](mailto:{{ $contact['email'] ?? '' }})

**Phone Number:**  
{{ !empty($contact['phone']) ? $contact['phone'] : 'Not provided' }}

**Date Received:**  
{{ now()->format('F j, Y \a\t g:i A') }}

## Message

{{ $contact['message'] ?? 'No message was provided.' }}

@isset($contact['email'])
<x-mail::button :url="'mailto:' . $contact['email'] . '?subject=' . rawurlencode('Re: ' . ($contact['subject'] ?? 'Your enquiry'))">
Reply to {{ $contact['first_name'] ?? 'Sender' }}
</x-mail::button>
@endisset

Thanks,<br>
**FMAP Media Website**

---

<small>
This message was submitted through the contact form on the FMAP Media website.  
Please verify the sender's identity before sharing confidential information.
</small>
</x-mail::message>