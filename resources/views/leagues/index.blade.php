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
