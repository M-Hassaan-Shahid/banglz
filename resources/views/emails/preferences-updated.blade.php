@component('mail::message')
# Communication Preferences Updated

Hello {{ $userName }},

Your communication preferences have been successfully updated.

## Your Current Preferences

@foreach($preferences as $preference)
- **{{ $preference['label'] }}:** {{ $preference['value'] }}
@endforeach

You can update these preferences at any time from your account settings.

@component('mail::button', ['url' => route('preferences.edit')])
Manage Preferences
@endcomponent

Thanks,<br>
{{ config('app.name') }}

---

*You're receiving this email because you updated your communication preferences. If you didn't make this change, please contact our support team.*
@endcomponent
