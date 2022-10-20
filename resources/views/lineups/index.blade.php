<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-nav-link :href="route('lineups', [auth()->user()->UserSetting->league])" :active="request()->routeIs('lineups')">
                <i class="fa-solid fa-users"></i>
                <div class="ml-1">{{ __('All lineups') }}</div>
            </x-nav-link>

            <x-nav-link :href="route('lineup', [auth()->user()->UserSetting->league, auth()->user()->team])" :active="request()->routeIs('lineup')">
                <i class="fa-solid fa-clipboard"></i>
                <div class="ml-1">{{ __('Your lineup') }}</div>
            </x-nav-link>
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    @if ($fixtures->count())

        <div class="pt-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="flex justify-between">
                        <form action="{{ route('lineups', [auth()->user()->UserSetting->league]) }}" method="POST">
                        @csrf
                        @METHOD('GET')
                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                            
                                <x-label for="fixture" :value="__('Select Fixture')" />
                                <select name="fixture" id="">
                                    
                                    
                                    @foreach ($fixtures as $value)
                                    {{-- Used $value otherwise we have a conflict with $fixture coming from controller --}}
                        
                                        <option :value="{{ $value->fixture }}" 
                                            @selected(old('fixture', $value->fixture == $fixture))>
                                            {{ $value->fixture }}
                                        </option>

                                        {{-- //FIXME - We can get rid of it, look at the LineupController index query --}}
                                        {{-- @if ($fixture == $value->fixture + 1)
                                            <option :value="{{ $fixture }}" 
                                                @selected(old('fixture', $fixture))>
                                                {{ $fixture }}
                                            </option>
                                        @endif --}}
                                    @endforeach
                                </select>

                                <x-button>
                                    {{ __('Change Fixture') }}
                                </x-button>

                                {{-- <button @click="alert($event.target.getAttribute('message'))" message="Hello World">Say Hi</button> --}}
 
                        </form>

                        @if ($fixture)
                            <span class="mr-2">{{ __('Current Fixture: ') }}
                                {{ $fixture }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="pt-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex">
                    
                </div>
            </div>
        </div> --}}


        {{-- loop all the teams in the league --}}
        <div class="grid grid-cols-2 gap-2">
            @foreach ($league->teams as $team)

            <div class="">
                <div class="mt-2 p-4 bg-white border-b border-gray-200 sm:rounded-lg">
                    <b>{{ $team->name }}</b> 
                    @if ($team->user_id === auth()->user()->id)
                        {{ __('(Your team)') }}
                    @endif 
                </div>
                {{-- Pitch --}}
                <x-table.table class="w-1" :headers="['Pitch', '', '', '+/-', 'Score', 'F Score']">

                    @foreach ($players as $player)
                                @if ($team->id === $player->team_id && $player->player_status === 1)
                                {{-- //TODO - sort it using alpine --}}        
                                    <tr class="border-b border-gray-200">

                                        <x-table.td>{{ $player->role }}</x-table.td>
                                        <x-table.td>{{ $player->surname }}</x-table.td>
                                        <x-table.td>{{ substr($player->team, 0, 3) }}</x-table.td>
                                        <x-table.td>{{ ('') }}</x-table.td>
                                        <x-table.td>{{ ('7') }}</x-table.td>
                                        <x-table.td>{{ ('7 +/-') }}</x-table.td>       
                                    </tr>
                                @endif
                            @endforeach
                </x-table.table>

                {{-- Bench --}}
                <x-table.table class="w-1" :headers="['Bench', '', '', '+/-', 'Score', 'F Score']">

                    @foreach ($players as $player)
                                @if ($team->id === $player->team_id && $player->player_status === 0)
                                {{-- //TODO - sort it using alpine --}}        
                                    <tr class="border-b border-gray-200">

                                        <x-table.td>{{ $player->role }}</x-table.td>
                                        <x-table.td>{{ $player->surname }}</x-table.td>
                                        <x-table.td>{{ substr($player->team, 0, 3) }}</x-table.td>
                                        <x-table.td>{{ ('') }}</x-table.td>
                                        <x-table.td>{{ ('7') }}</x-table.td>
                                        <x-table.td>{{ ('7 +/-') }}</x-table.td>       
                                    </tr>
                                @endif
                            @endforeach
                </x-table.table>

                
            </div>
                @endforeach
        </div>

    @else
        <div class="pt-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('No lineups to display yet') }}
                </div>
            </div>
        </div>
            
    @endif
               
    </div>

</x-app-layout>
