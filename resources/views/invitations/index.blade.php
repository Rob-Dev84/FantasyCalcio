<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invitations management') }}
        </h2>
    </x-slot>

{{-- Visible only to the league Admin --}}

    {{-- @if (Auth::user()->id === $league->user_id)  --}}
    {{-- If true user owns the league --}}

    {{-- @if (Auth::user()->userSetting)  --}}
    {{-- I want to check if userSetting->league_id === --}}

    {{-- {{ dd(auth()->user()->leagues->contains(Auth::user()->userSetting->league_id)) }} --}}
    @if (Auth::user()->userSetting->league_id === NULL)
        <div class="p-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                        <div>
                        {{ __("League is not selected. Invitation is not avaible") }}
                        </div>
                        <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-gray-500">
                            {{ __('Invite') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if (!auth()->user()->leagues->contains(Auth::user()->userSetting->league_id))
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                        <div>
                        {{ __("Only League Admin can invite other friends") }}
                        </div>
                        <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-gray-500">
                            {{ __('Invite') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    
    

    @if (auth()->user()->leagues->contains(Auth::user()->userSetting->league_id)) {{-- Here we check if 'id_user' form the league table matches the 'user_id' from userSetting table --}}
    
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                        <div>
                        {{ __('As League Admin, you invited') }} {{ $sentInvitations->count() }} {{ Str::plural('friend', $sentInvitations->count()) }} {{ __(' to join the league: ') }} 
                        <b> {{ $leagueOwnedBy->name }} </b> 
                        {{-- I get the name by quering the league table on invitation controller
                        I'm sure we can achieve it via relationships --}}
                        </div>
                        <x-dropdown-link class="px-0 py-0"  :href="route('invitations.create')" :active="request()->routeIs('invitations.create')">
                            <x-button class="ml-4">
                                {{ __('Invite') }}
                            </x-button>
                        </x-dropdown-link>
                    </div>
                </div>
            </div>
        </div>
    
        @if($sentInvitations)

        @foreach ($sentInvitations as $sentInvitation)
        <div class="pt-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pl-6 py-2 bg-white border-b border-gray-200">
                        <ul>
                            <li class="flex items-center justify-between">

                                <div>
                                {{ $sentInvitation->email }}
                                </div>
                                <div class="flex items-center justify-end pr-6">
                                    @if ($sentInvitation->confirmed === 1)
                                    {{-- <x-button class="ml-4 bg-green-500">
                                        {{ __('Accepted') }}
                                    </x-button> --}}
                                    <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-green-500">
                                        {{ __('Accepted') }}
                                    </div>
                                    @elseif($sentInvitation->confirmed === NULL)
                                    {{-- <x-button class="ml-4 bg-orange-500">
                                        {{ __('Pending') }}
                                    </x-button> --}}
                                    <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-orange-500">
                                        {{ __('Pending') }}
                                    </div>
                                    @else
                                    {{-- <x-button class="ml-4 bg-red-500">
                                        {{ __('Declined') }}
                                    </x-button> --}}
                                    <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-red-500">
                                        {{ __('Declined') }}
                                    </div>
                                    @endif

                                    <form action="{{ route('invitation.softDelete', $sentInvitation) }}" method="POST">
                                        @csrf
                                        @method('DELETE') 
                                        <x-button class="ml-4 bg-red-500">
                                            {{ __('Delete') }}
                                        </x-button>
                                    </form>
                                </div>
                                
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <hr class="mt-6">
        @endif

    @endif

    <hr>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{ __('You received ') }} {{ $receivedInvitations->count() }} {{ Str::plural('invitation ', $receivedInvitations->count()) }}
                    {{ __('from other leagues ') }}
                </div>
            </div>
        </div>
    </div>
{{-- {{ dd($receivedInvitation) }} --}}
    @if($receivedInvitation)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="pl-6 py-2 bg-white border-b border-gray-200">
                    
                    <ul>
                        <li class="flex items-center justify-between">
                            <div>
                            {{ __('You have an invitation for the league:') }}
                            <b> {{ $league->name }} </b>
                            {{-- {{ dd($user->name) }}  --}}
                            </div>
                            <div class="flex items-center justify-end pr-6">
                            @if($receivedInvitation->confirmed === 1)
                                <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-green-500">
                                    {{ __('Accepted') }}
                                </div>
                                @elseif($receivedInvitation->confirmed === 0)
                                <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-red-500">
                                    {{ __('Declined') }}
                                </div>
                                @else
                                <form action="{{ route('invitation.accept', $receivedInvitation) }}" method="POST">
                                    @csrf
                                    @method('PUT') 
                                    <x-button class="ml-4">
                                        {{ __('Accept') }}
                                    </x-button>
                                </form>

                                <form action="{{ route('invitation.decline', $receivedInvitation) }}" method="POST">
                                    @csrf
                                    @method('PUT') 
                                    <x-button class="ml-4 bg-red-500">
                                        {{ __('Decline') }}
                                    </x-button>
                                </form>
                                @endif       
                            </div>   
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif


    
</x-app-layout>
