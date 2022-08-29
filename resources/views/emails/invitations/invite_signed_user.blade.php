@component('mail::message')
# {{ __('FantasyCalcio Invitation') }}


{{ __('Hi ') }} {{ $user->name }} {{ ',' }}

{{ Auth::user()->name }} {{ Auth::user()->surname }} {{ __(' invited you to join the league: ') }} <b>{{ Auth::user()->userSetting->league->name }}</b> 

{{ __('Login and go to the invitations section to accept it.') }}

{{ __('Enjoy!') }}

@component('mail::button', ['url' => 'http://localhost/login'])
{{ __('Login') }}
@endcomponent

{{ __("If you don't know this user, you can login and decline the invitation.") }}

{{ __('Team') }},<br>
{{ config('app.name') }}
@endcomponent
