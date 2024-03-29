@component('mail::message')
# {{ __('FantasyCalcio Invitation ') }}


{{ __('Welcome to FantasyCalcio.') }}

{{ auth()->user()->name }} {{ auth()->user()->surname }} {{ __(' invited you to join the league: ') }} <b>{{ auth()->user()->userSetting->league->name }}</b>

{{ __('Sign up your account and go to the invitations section to accept it.') }}

{{ __('Enjoy!') }}

@component('mail::button', ['url' => 'http://localhost/register'])
{{ __('Sign up') }}
@endcomponent

{{ __("If you don't know this user, ignore this email.") }}

{{ __('Team') }},<br>
{{ config('app.name') }}
@endcomponent
