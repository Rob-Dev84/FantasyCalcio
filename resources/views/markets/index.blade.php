<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Market: Serie A') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- //TODO - make the search input --}}

    {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{
        players:[],
        q: '',
        async submit(){
            this.players = await (await fetch('/markets/{{ auth()->user()->userSetting->league->name }}/search', 
            {

                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content 
                },
                body: JSON.stringify({q:this.q})

            })).json();
        }
    }" x-init="players = await(await fetch('/markets/{{ auth()->user()->userSetting->league->name }}')).json()"> --}}


        <div class="pt-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between">
                        <ul class="flex flex-col">
                            <li>{{ __('Your current budget is:') }} <b>{{ auth()->user()->team->budget }} {{ 'ML' }}</b></li>
                            <li>{{ __('Number of players bought:') }} <b>{{ $teamPlayers->count() }} {{ '/ 25' }}</b></li>
                            @if ($teamPlayers->count() === 25)
                                <li><b>{{ __('Well done, Market completed') }}</b></li>
                            @endif
                        </ul>
                        
                        <ul class="flex flex-col">
                            <li>{{ __('Goalkeepers:') }} {{ $numerGoalkeepers}} {{'/ 3' }}</li>
                            <li>{{ __('Defenders:') }} {{ $numerDefenders}} {{'/ 8' }}</li>
                            <li>{{ __('Midfielders:') }} {{ $numerMidfielders}} {{'/ 8' }}</li>
                            <li>{{ __('Strikers:') }} {{ $numerStrikers}} {{'/ 6' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- search input --}}
        {{-- <form action="">
            @csrf
            <x-input type="text" x-model="q" @input.debounce="submit"></x-input>
        </form> --}}
    
        <div class="pt-1">
        @if ($players->count())
         
        <x-table.table :headers="['Name','Role','Team','C. Value','I. Value',['name' => 'Actions', 'class' => 'text-center']]">
            @foreach ($players as $player)

                <tr class="border-b border-gray-200">
                    <x-table.td>{{ $player->surname }}</x-table.td>
                    <x-table.td>{{ $player->role }}</x-table.td>
                    <x-table.td>{{ $player->team }}</x-table.td>
                    <x-table.td><b>{{ $player->current_value }}</b></x-table.td>
                    <x-table.td>{{ $player->initial_value }}</x-table.td>
                    
                    <x-table.td class="flex justify-center">
                    
                       @if (!$team->markets->contains('player_id', $player->id))
                        <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true" action="{{ route('markets.buy', [$league, $team, $player]) }}" method="POST">
                            @csrf
                            <x-button x-bind:disabled="btnDisabled" class="ml-4 w-8 h-8 flex justify-center bg-green-500">
                                <i title="{{ __('Buy for') }} {{ $player->current_value }} {{ __('ml') }}" class="fa-solid fa-euro-sign"></i>
                            </x-button>
                        </form>

                        <x-icon-btn class="opacity-40 bg-red-500">
                            <i title="{{ __('Action not available') }}" class="fa-solid fa-trash"></i>
                        </x-icon-btn>
                       @else

                        <x-icon-btn class="opacity-40 bg-green-500">
                            <i title="{{ __('You already bought this player') }}" class="fa-solid fa-euro-sign"></i>
                        </x-icon-btn>

                        <form x-data="{ btnDisabled: false }" @submit="btnDisabled = true" action="{{ route('markets.sell', [$league, $team, $player]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button x-bind:disabled="btnDisabled" class="ml-4 w-8 h-8 flex justify-center bg-red-500">
                                <i title="{{ __('Sell for') }} {{ $player->current_value }} {{ __('ml') }}" class="fa-solid fa-trash"></i>
                            </x-button>
                        </form>

                       @endif
                       
                    </x-table.td>
                </tr>
            @endforeach
        </x-table.table>

        {{ $players->links('pagination::tailwind') }}

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
                    
    </div>
</x-app-layout>
