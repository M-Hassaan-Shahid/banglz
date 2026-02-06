@component('mail::message')
# Password Changed Successfully

Hello {{ $userName }},

Your password was successfully changed on {{ $changedAt }}.

If you made this change, no further action is required.

## Security Recommendations

- Never share your password with anyone
- Use a unique password for each online account
- Consider using a password manager
- Enable two-factor authentication when available
- If you didn't make this change, please contact us immediately

@component('mail::button', ['url' => route('personal-account')])
View Your Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}

---

*This is an automated security notification. If you did not request this password change, please contact our support team immediately.*
@endcomponent
