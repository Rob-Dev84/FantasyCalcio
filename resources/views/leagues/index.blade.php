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
                    <p>You don't own any league yet</p>
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
                <ol>
                    <div class="pt-1">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="pl-6 py-2 bg-white border-b border-gray-200">
                            
                                    <li class="flex items-center justify-between">
                                        <div>
                                        {{ $leagues_guest->name }} 
                                        </div>
                                        <div class="flex items-center justify-end pr-6">
                                            @if ($leagueSelected->league_id != $receivedInvitation->league_id)
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
                                        </div>
                                    </li>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                            
                @else
                    <p>You don't have League invitation to display</p>
                @endif
            </ol>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                   {{ __('Create new league (move to create.blade.php file)') }}   

                </div>
            </div>
        </div>
    </div>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('league') }}">
                        @csrf

                        <!-- League Name -->
                        <div>
                            <x-label for="name" :value="__('League Name')" />

                            <x-input id="" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <div class="flex justify-between">
                            <!-- Legue Selection -->
                            <div class="mt-4">
                                <x-label for="league" :value="__('Select your League')" />
                                <div class="flex items-center">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="1" required />
                                    <x-label for="league_type" :value="__('Serie A')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="2" disabled />
                                    <x-label for="league_type" :value="__('Premier League')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="3" disabled />
                                    <x-label for="league_type" :value="__('LaLiga')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="4" disabled />
                                    <x-label for="league_type" :value="__('Ligue 1')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="5" disabled />
                                    <x-label for="league_type" :value="__('Bundesliga')" />
                                </div>
                                
                                {{-- <x-input id="league_eng" class="block mt-1" type="radio" name="league_eng" :value="old('league_eng')" disabled/> --}}
                        
                            </div>

                            <!-- Markert type -->
                            <div class="mt-4">
                                <x-label for="market" :value="__('Type of market')" />
                                <div class="flex items-center">
                                    <x-input id="market_type" class="block mr-1" type="radio" name="market_type" :value="1" required />
                                    <x-label for="market_type" :value="__('Free')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="market_type" :value="2" disabled />
                                    <x-label for="market_type" :value="__('Auction')" />
                                </div>
                                
                                {{-- <x-input id="league_eng" class="block mt-1" type="radio" name="league_eng" :value="old('league_eng')" disabled/> --}}
                        
                            </div>

                            <!-- Score type -->
                            <div class="mt-4">
                                <x-label for="score_type" :value="__('Select your League')" />
                                <div class="flex items-center">
                                    <x-input id="" class="block mr-1" type="radio" name="score_type" :value="1" required />
                                    <x-label for="score_type" :value="__('Points')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="score_type" :value="2" disabled />
                                    <x-label for="score_type" :value="__('Formula one')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="score_type" :value="3" disabled />
                                    <x-label for="score_type" :value="__('fixtures')" />
                                </div>
                                
                                {{-- <x-input id="league_eng" class="block mt-1" type="radio" name="league_eng" :value="old('league_eng')" disabled/> --}}
                        
                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="mt-4">
                            <x-label for="budget" :value="__('League Budget')" />

                            <x-input id="budget" class="block mt-2 w-full" type="number" name="budget" :value="old('budget')" required autofocus />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create League') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- trashed league --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    Leagues trashed
                  
                </div>
            </div>
        </div>
    </div>
        

    @if ($leagues_deleted->count())
            @foreach ($leagues_deleted as $league_deleted)
            <ol>
                <div class="py-2">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="pl-6 py-2 bg-white border-b border-gray-200">
                        
                                <li class="flex items-center justify-between">
                                    <div>
                                    {{ $league_deleted->name }} 
                                    </div>
                                    <div class="flex items-center justify-end pr-6">

                                        {{-- OK --}}
                                        <form action="{{ route('leagues.restore', $league_deleted) }}" method="POST">
                                            @csrf
                                            <x-button class="ml-4">
                                                {{ __('Restore') }}
                                            </x-button>
                                        </form>

                                        {{-- To fix: Force Delete --}}
                                        <form action="{{ route('leagues.forceDelete', $league_deleted) }}" method="POST">
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
                    <p>Your trash is empty</p>
                @endif
            </ol>

</x-app-layout>
