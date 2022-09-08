<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('League management') }}
        </h2>
    </x-slot>



    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{ __('My leagues as Admin') }}
                    
                </div>
            </div>
        </div>
    </div>

    <div class="pt-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-2 bg-gray-200 border-b border-gray-300">

                    <ul class="flex">
                        <li class="">{{ __('Name') }}</li>
                        <li class="mx-6">{{ __('League') }}</li>
                        <li class="mx-6">{{ __('Market') }}</li>
                        <li class="mx-6">{{ __('Score') }}</li>
                        <li class="mx-6">{{ __('Budget') }}</li>
                        <li class="mx-6">{{ __('Actions') }}</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    @if ($leagues->count())
        @foreach ($leagues as $league)
        <ol>
            <div class="pt-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="pl-6 py-2 bg-white border-b border-gray-200">
                    
                            <li class="flex items-center justify-between">
                                <div>
                                {{ $league->name }} 
                                </div>
                                <div class="flex items-center justify-end pr-6">
                                    @if ($leagueSelected->league_id != $league->id)
                                    <form action="{{ route('leagues.select', $league) }}" method="POST">
                                        @csrf
                                        @method('PUT') 
                                        <x-button class="ml-4">
                                            {{ __('Select') }}
                                        </x-button>
                                    </form>
                                    @else
                                    <div class="py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-green-500">
                                        {{ __('Selected') }}
                                    </div>
                                    @endif

                                    {{-- Modify League --}}
                                    @if (auth()->user()->leagues->contains(auth()->user()->userSetting->league_id))
                                    <form action="{{ route('league.edit', $league) }}" method="POST">
                                        @csrf
                                            @method('GET') 
                                        <x-button class="ml-4 bg-orange-500">
                                            {{ __('Modify') }}
                                        </x-button>
                                    </form>
                                    @else
                                        <x-button class="ml-4 bg-red-500">
                                            {{ __('Modify') }}
                                        </x-button>
                                    @endif
                                    

                                    {{-- Soft Delete --}}
                                    <form action="{{ route('leagues.softDelete', $league) }}" method="POST">
                                        @csrf
                                            @method('DELETE') 
                                        <x-button class="ml-4 bg-red-500">
                                            {{ __('Delete') }}
                                        </x-button>
                                    </form>
                                </div>
                            </li>
            
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
                        
            @else
            <div class="pt-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="pl-6 py-2 bg-white border-b border-gray-200">
                    
                            {{ __("You don't own any league") }}
            
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </ol>
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{ __('My leagues as Guess') }}

                </div>
            </div>
        </div>
    </div>

    <div class="pt-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-2 bg-gray-200 border-b border-gray-300">

                    <ul class="flex">
                        <li class="">{{ __('Name') }}</li>
                        <li class="mx-6">{{ __('League') }}</li>
                        <li class="mx-6">{{ __('Market') }}</li>
                        <li class="mx-6">{{ __('Score') }}</li>
                        <li class="mx-6">{{ __('Budget') }}</li>
                        <li class="mx-6">{{ __('Actions') }}</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    @if ($receivedInvitations->count())
            @foreach ($receivedInvitations as $receivedInvitation)
                @if ($receivedInvitation->confirmed)
                {{-- {{ dd($leagues_guest) }} --}}
                <ol>
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="pl-6 py-2 bg-white border-b border-gray-200">
                            
                                    <li class="flex items-center justify-between">
                                        <div>
                                        {{ $leagues_guest->name }} 
                                        @if($leagues_guest->trashed())
                                        {{ __('(Trashed by your League Admin)') }} 
                                        @endif
                                        </div>
                                        <div class="flex items-center justify-end pr-6">
                                            {{-- {{ dd($leagues_guest->trashed()); }} --}}
                                            @if($leagues_guest->trashed())
                                            <div class="opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-gray-500">
                                                {{ __('Select') }}
                                            </div>
                                            @elseif($leagueSelected->league_id != $receivedInvitation->league_id)
                                            <form action="{{ route('leagues.select', $receivedInvitation->league_id) }}" method="POST">
                                                @csrf
                                                @method('PUT') 
                                                <x-button class="ml-4">
                                                    {{ __('Select') }}
                                                </x-button>
                                            </form>
                                            @else
                                            <div class="py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-green-500">
                                                {{ __('Selected') }}
                                            </div>
                                            @endif
                                            <div title="{{ __('You cannot modify this league') }}" class="ml-4 opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-orange-500">
                                                {{ __('Modify') }}
                                            </div>
                                            <div title="{{ __('You cannot delete this league') }}" class="ml-4 opacity-70 py-2 px-4 uppercase text-xs text-white font-semibold tracking-widest rounded-md bg-red-500">
                                                {{ __('Delete') }}
                                            </div>
                                        </div>
                                    </li>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                            
                @else
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="pl-6 py-2 bg-white border-b border-gray-200">
                            
                                    {{ __("No League to display") }}
                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </ol>

</x-app-layout>
