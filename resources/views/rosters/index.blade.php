<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rosters') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- <div class="py-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('Here is your Roster') }}
                </div>
            </div>
        </div> --}}


        @if ($league->teams->isEmpty())

         <div class="py-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __("This league doesn't contain any teams yet") }}
                </div>
            </div>
        </div>
            
        @else

            @foreach ($league->teams as $team)

            <div class="mt-2 p-4 bg-white border-b border-gray-200 sm:rounded-lg">
                <b>{{ $team->name }}</b> 
                    @if ($team->user_id === auth()->user()->id)
                    {{ __('(Your team)') }}
                    @endif 
            </div>

                @if ($players->count())
                    <x-table.table :headers="['Role', 'Footballer', 'Squad','Enquiry Value', 'Current Value']">
                
                        @foreach ($players as $player)
                            @if ($team->user_id === $player->user_id)
                            {{-- //TODO - sort it using alpine --}}        
                                <tr class="border-b border-gray-200">

                                    <x-table.td>{{ $player->role }}</x-table.td>
                                    <x-table.td>{{ $player->surname }}</x-table.td>
                                    <x-table.td>{{ $player->team }}</x-table.td>
                                    <x-table.td>{{ $player->expense }}</x-table.td>
                                    <x-table.td>{{ $player->current_value }}</x-table.td>       
                                </tr>
                            @endif
                        @endforeach

                    </x-table.table>
                @endif
            @endforeach
            
        @endif

        

        
    </div>
</x-app-layout>