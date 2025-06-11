@component('mail::message')
# You've been invited to join {{ config('app.name') }}

You have been invited to join as a **{{ $invitation->role }}** for **{{ $invitation->company->name }}**.

@component('mail::button', ['url' => route('invitations.accept', $invitation->token)])
Accept Invitation
@endcomponent

This invitation will expire in 7 days.

Thanks,<br>
{{ config('app.name') }}
@endcomponent