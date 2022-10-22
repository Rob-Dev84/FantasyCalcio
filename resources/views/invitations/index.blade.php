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
    @if (auth()->user()->userSetting && auth()->user()->userSetting->league_id === NULL)
        <div class="p-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                        <div>
                        {{ __("League is not selected. Invitation is not avaible") }}
                        </div>
                        <x-tag class="opacity-40 bg-gray-500">
                            {{ __('Invite') }}
                        </x-tag>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->userSetting && !auth()->user()->leagues->contains(auth()->user()->userSetting->league_id))
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                        <div>
                        {{ __("Only League Admin can invite other friends") }}
                        </div>
                        <x-tag class="opacity-40 bg-gray-500">
                            {{ __('Invite') }}
                        </x-tag>
                    </div>
                </div>
            </div>
        </div>
    @endif

    
    

    @if (auth()->user()->userSetting && auth()->user()->leagues->contains(auth()->user()->userSetting->league_id)) {{-- Here we check if 'id_user' form the league table matches the 'user_id' from userSetting table --}}
    
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                        <div>
                        {{ __('As League Admin, you invited') }} {{ $sentInvitations->count() }} {{ Str::plural('friend', $sentInvitations->count()) }} {{ __(' to join the league: ') }} 
                        <b> {{ auth()->user()->userSetting->league->name }} </b> 
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
    
        {{-- {{ dd(auth()->user()->sentInvitations) }} --}}
        {{-- {{ dd($sentInvitations) }} --}}
        {{-- {{ dd(auth()->user()->userSetting()->sentInvitations) }} --}}
        {{-- {{ dd(auth()->user()->userSetting->league_id) }} --}}
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
                                    <x-tag class="opacity-70 bg-green-500">
                                        {{ __('Accepted') }}
                                    </x-tag>
                                    @elseif($sentInvitation->confirmed === NULL)
                                    <x-tag class="opacity-70 bg-orange-500">
                                        {{ __('Pending') }}
                                    </x-tag>
                                    @else
                                    <x-tag class="opacity-70 bg-red-500">
                                        {{ __('Declined') }}
                                    </x-tag>
                                    @endif
                                    <form action="{{ route('invitation.softDelete', $sentInvitation) }}" method="POST">
                                        @csrf
                                        @method('DELETE') 
                                        <x-button class="ml-4 w-8 h-8 flex justify-center bg-red-500">
                                            <i title="{{ __('Delete') }}" class="fa-solid fa-trash"></i>
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

                    {{ __('You received ') }} {{ auth()->user()->receivedInvitations->count() }} {{ Str::plural('invitation ', auth()->user()->receivedInvitations->count()) }}
                    {{ __('from other leagues ') }}
                </div>
            </div>
        </div>
    </div>
    {{-- {{ dd(auth()->user()->receivedInvitations) }} --}}
    @if(auth()->user()->receivedInvitations)
        @foreach (auth()->user()->receivedInvitations as $receivedInvitation)
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pl-6 py-2 bg-white border-b border-gray-200">
                        
                        <ul>
                            <li class="flex items-center justify-between">
                                <div>
                                {{ __('You have an invitation for the league:') }}
                                <b> {{ $receivedInvitation->league->name }} </b>
                                {{-- {{ dd($user->name) }}  --}}
                                </div>
                                <div class="flex items-center justify-end pr-6">
                                @if($receivedInvitation->confirmed === 1)
                                    <x-tag class="bg-green-500">
                                        {{ __('Accepted') }}
                                    </x-tag>
                                    @elseif($receivedInvitation->confirmed === 0)
                                    {{-- <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-red-500">
                                        {{ __('Declined') }}
                                    </div> --}}
                                    <x-tag class="opacity-70 bg-red-500">
                                        {{ __('Declined') }}
                                    </x-tag>
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
        @endforeach
    @endif


    
</x-app-layout>
