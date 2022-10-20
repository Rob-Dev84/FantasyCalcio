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

    {{-- Each Fixture, User can create/modify lineups only before the start of the first match --}}
    @if ($fixture && !is_null($expiredFixure))

        <div class="pt-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between">
                        <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true" action="
                        {{ route('module.store') }}
                        " method="POST">
                            @csrf

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                            <x-label for="module_type_id" :value="__('Select Module')" />
                            <select name="module_type_id" id="">
                                @if (!auth()->user()->team->module)
                                    <option value="">S. Moldule</option>
                                @endif
                                
                                @foreach ($modules as $module)
                                    <option
                                        :value="{{ $module->id }}"
                                        {{-- {{old('module_type_id',auth()->user()->team->module && auth()->user()->team->module->module_type_id === $module->id ) ? 'selected' : ''}}  --}}
                                        @selected(old('module_type_id', auth()->user()->team->module && auth()->user()->team->module->module_type_id === $module->id))
                                        >
                                        {{ $module->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <x-button x-bind:disabled="btnDisabled" class="ml-4 h-8 flex justify-center {{ (auth()->user()->team->module) ? 'bg-green-500' : 'bg-gray-500' }} ">
                                <span title="{{ __('Insert module') }}" class="mr-2">{{ (auth()->user()->team->module) ? __('Selected') : __('Select') }}
                                    @if (auth()->user()->team->module)
                                        <i class="fa-solid fa-check"></i>
                                    @endif
                                </span>
                            </x-button>
                            
                            @if (auth()->user()->team->module)
                            <span title="class="mr-2">{{ __('Module selected') }}
                            </span>
                            @endif
                        </form>

                        
                        <ul class="flex flex-col">
                            <li>{{ __('Pitch') }}</li>
                            <li>{{ __('Goalkeepers:') }} {{ $countPitchGoalkeepers}} {{'/ 1' }}</li>
                            <li>{{ __('Defenders:') }} {{ $countPitchDefenders}} {{'/ ' }} {{ $numberModuleDefenters }}</li>
                            <li>{{ __('Midfielders:') }} {{ $countPitchMidfields}} {{'/ ' }} {{ $numberModuleMidfields }}</li>
                            <li>{{ __('Strikers:') }} {{ $countPitchStrickers}} {{'/ ' }} {{ $numberModuleStrikers }}</li>
                        </ul>

                        <ul class="flex flex-col">
                            <li>{{ __('Bench') }}</li>
                            <li>{{ __('Goalkeepers:') }} {{ $countBenchGoalkeepers}} {{'/ 1' }}</li>
                            <li>{{ __('Defenders:') }} {{ $countBenchDefenders}} {{'/ 3' }}</li>
                            <li>{{ __('Midfielders:') }} {{ $countBenchMidfields}} {{'/ 3' }}</li>
                            <li>{{ __('Strikers:') }} {{ $countBenchStrickers}} {{'/ 3' }}</li>
                        </ul>
                        

                    </div>
                </div>
            </div>
        </div>
        
        <div class="pt-1">
        @if ($players->count())
         
        <x-table.table :headers="['Name','Role','Team',['name' => 'Actions', 'class' => 'text-center']]">
            @foreach ($players as $index => $player)

            {{-- {{ dd($player->player); }} --}}

                <tr class="border-b border-gray-200">
                    <x-table.td>{{ $player->player->role }}</x-table.td>
                    <x-table.td>{{ $player->player->surname }}</x-table.td>
                    
                    <x-table.td>{{ $player->player->team }}</x-table.td>
                  
                    
                    <x-table.td class="flex justify-center">
                        {{-- {{ dd(empty($lineup_players)) }} --}}
                    
                    
                    {{-- Case when team is on this page for the first time ever. No previous lineup is set   --}}
                    @if ($lineup_players->isEmpty())

                        <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true" 
                        action="{{ route('lineup.pitch', [$league, $team, $fixture, $player->player]) }}" method="POST">
                            @csrf
                            <x-button x-bind:disabled="btnDisabled" class="ml-4 w-8 h-8 flex justify-center bg-green-500">
                                <i title="{{ __('Deploy to the pitch') }}" class="fa-solid fa-person-running"></i>
                            </x-button>
                        </form>

                        {{-- //deploy player to the bench --}}
                        <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true" 
                        action="{{ route('lineup.bench', [$league, $team, $fixture, $player->player]) }}" method="POST">
                            @csrf
                            <x-button x-bind:disabled="btnDisabled" class="ml-4 w-8 h-8 flex justify-center bg-orange-500">
                                <i title="{{ __('Deploy to the bench') }}" class="fa-solid fa-chair"></i>
                            </x-button>
                        </form>

                        {{-- //Undo the player --}}
                        <x-icon-btn class="opacity-40 bg-red-500">
                            <i title="{{ __('Action not available') }}" class="fa-solid fa-rotate-left"></i>
                        </x-icon-btn>
                        
                    @endif
                     
                    @foreach ($lineup_players as $lineup_player)

                        {{-- status player by default (out) --}}
                        @if ($player->player_id === $lineup_player->player_id && $lineup_player->player_status === null)
                            
                            {{-- {{ $player->player_id }} --}}
                                <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true" 
                                action="{{ route('lineup.pitch', [$league, $team, $fixture, $player->player]) }}" method="POST">
                                    @csrf
                                    <x-button x-bind:disabled="btnDisabled" class="ml-4 w-8 h-8 flex justify-center bg-green-500">
                                        <i title="{{ __('Deploy to the pitch') }}" class="fa-solid fa-person-running"></i>
                                    </x-button>
                                </form>

                                {{-- //deploy player to the bench --}}
                                <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true" 
                                action="{{ route('lineup.bench', [$league, $team, $fixture, $player->player]) }}" method="POST">
                                    @csrf
                                    <x-button x-bind:disabled="btnDisabled" class="ml-4 w-8 h-8 flex justify-center bg-orange-500">
                                        <i title="{{ __('Deploy to the bench') }}" class="fa-solid fa-chair"></i>
                                    </x-button>
                                </form>

                                {{-- //Undo the player --}}
                                <x-icon-btn class="opacity-40 bg-red-500">
                                    <i title="{{ __('Action not available') }}" class="fa-solid fa-rotate-left"></i>
                                </x-icon-btn>

                        {{-- status player by default (pitch) --}}
                        @elseif($player->player_id === $lineup_player->player_id && $lineup_player->player_status === 1)
                                
                                <x-icon-btn class="opacity-40 bg-green-500">
                                    <i title="{{ __('Player on Pitch') }}" class="fa-solid fa-person-running"></i>
                                </x-icon-btn>

                                <x-icon-btn class="opacity-40 bg-gray-500">
                                    <i title="{{ __('Player on Bench') }}" class="fa-solid fa-chair"></i>
                                </x-icon-btn>

                                {{-- //Undo the player --}}
                                <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true"
                                action="{{ route('lineup.undo', [$league, $team, $fixture, $player->player]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button x-bind:disabled="btnDisabled" class="ml-4 w-8 h-8 flex justify-center bg-red-500">
                                        <i title="{{ __('Reset selection') }}" class="fa-solid fa-rotate-left"></i>
                                    </x-button>
                                </form>

                        {{-- status player by default (bench) --}}
                        @elseif($player->player_id === $lineup_player->player_id && $lineup_player->player_status === 0)
                                <x-icon-btn class="opacity-40 bg-gray-500">
                                    <i title="{{ __('Player on Pitch') }}" class="fa-solid fa-person-running"></i>
                                </x-icon-btn>

                                <x-icon-btn class="opacity-40 bg-orange-500">
                                    <i title="{{ __('Player on Bench') }}" class="fa-solid fa-chair"></i>
                                </x-icon-btn>


                                {{-- //Undo the player --}}
                                <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true"
                                action="{{ route('lineup.undo', [$league, $team, $fixture, $player->player]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button x-bind:disabled="btnDisabled" class="ml-4 w-8 h-8 flex justify-center bg-red-500">
                                        <i title="{{ __('Reset selection') }}" class="fa-solid fa-rotate-left"></i>
                                    </x-button>
                                </form>

                        @endif
                        @endforeach

                        {{-- @endif --}}
                       
                    </x-table.td>
                </tr>
            @endforeach
        </x-table.table>

        </div>    
            @else
            <div class="pt-1">   
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pl-6 py-2 bg-white border-b border-gray-200">
                
                        {{ __("List of players is not available") }}
        
                    </div>
                </div>   
            </div>
            @endif

    {{-- During the matches user cannot create/modify lineups --}}       
    @else
    <div class="pt-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                {{ __("You currently cannot insert or modify your lineup") }}
            </div>
        </div>   
    </div>
    @endif
    </div>
</x-app-layout>
