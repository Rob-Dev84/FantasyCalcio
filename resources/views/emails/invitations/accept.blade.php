@component('mail::message')
# {{ __('FantasyCalcio Invitation Accepted') }}


{{ __('Hi ') }} {{ $userAdmin->name }} {{ ',' }}

{{ auth()->user()->name }} {{ auth()->user()->surname }} {{ __(' joint your league: ') }} <b>{{ $leagueAdmin->name }}</b>

{{ __("If you accidentally made a wrong invitation, you can still login and delete it from the Invitations section.") }}

{{ __('Team') }},<br>
{{ config('app.name') }}
@endcomponent