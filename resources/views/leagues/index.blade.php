<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('League management') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="pt-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{ __('My leagues as Admin') }}
                    
                </div>
            </div>
        </div>
  
        {{-- {{ dd(auth()->user()->leagues) }} --}}

  
    <div class="pt-1">
        @if ($leagues->count())
         
        <x-table.table :headers="['Name','League','Market','Score','Budget',['name' => 'Actions', 'class' => 'text-center']]">
            @foreach ($leagues as $league)
            {{-- {{ dd($league); }}    --}}
                <tr class="border-b border-gray-200">
                    <x-table.td>{{ $league->name }}</x-table.td>
                    <x-table.td>{{ $league->leagueType->name }}</x-table.td>
                    <x-table.td>{{ $league->marketType->name }}</x-table.td>
                    <x-table.td>{{ $league->scoreType->name }}</x-table.td>
                    <x-table.td>{{ $league->budget }}</x-table.td>
                    
                    <x-table.td class="flex justify-center">
                    {{-- <td class="px-2 py-3 flex items-center justify-center"> --}}
                        @if (auth()->user()->userSetting->league_id !== $league->id)
                        <form action="{{ route('leagues.select', $league) }}" method="POST">
                            @csrf
                            @method('PUT') 
                            <x-button class="ml-4 w-8 h-8 flex justify-center">
                                <i title="{{ __('Select') }}" class="fa-solid fa-check"></i>
                            </x-button>
                        </form>
                        @else
                        <x-icon-btn class="bg-green-500">
                            <i title="{{ __('Selected') }}" class="fa-solid fa-check"></i>
                        </x-icon-btn>
                        @endif
                        <form action="{{ route('league.edit', $league) }}" method="POST">
                            @csrf
                            @method('GET') 
                            <x-button class="ml-4 w-8 h-8 flex justify-center bg-orange-500">
                                <i title="{{ __('Modify') }}" class="fa-solid fa-pen-to-square"></i>
                            </x-button>
                        </form>

                        <form action="{{ route('leagues.softDelete', $league) }}" method="POST">
                            @csrf
                                @method('DELETE') 
                            <x-button class="ml-4 w-8 h-8 flex justify-center bg-red-500">
                                <i title="{{ __('Delete') }}" class="fa-solid fa-trash"></i>
                            </x-button>
                        </form>
                    </x-table.td>
                </tr>
            @endforeach
        </x-table.table>

        </div>    
            @else
            <div class="pt-1">   
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pl-6 py-2 bg-white border-b border-gray-200">
                
                        {{ __("You don't own any league") }}
        
                    </div>
                </div>   
            </div>
            @endif
                    
          
    <div class="pt-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                {{ __('My leagues as Guest') }}

            </div>
        </div>
    </div>

    

    <div class="pt-1">
        @if (auth()->user()->receivedInvitations->count() > 0)
        <x-table.table :headers="['Name','League','Market','Score','Budget',['name' => 'Actions', 'class' => 'text-center']]">       
                    
            @foreach (auth()->user()->receivedInvitations as $receivedInvitation)
                       
                @if ($receivedInvitation->confirmed)
                <tr class="border-b border-gray-200">
                    <x-table.td>
                        @if ($receivedInvitation->trashed())
                            <span title="Your League Admin blocked you from this league">{{ $leagues_guest->name }}</span>
                            <sup class="text-red-500">
                                <i class="fa-solid fa-user-slash"></i>
                            </sup> 
                        @elseif ($leagues_guest->trashed()) 
                            <span title="Your League Admin locked this league">{{ $leagues_guest->name }}</span>
                            <sup class="text-red-500">
                                <i class="fa-solid fa-lock"></i>
                            </sup>
                        @else
                        <span title="">{{ $leagues_guest->name }}</span>
                        @endif
                    </x-table.td>
                    <x-table.td>{{ $leagues_guest->leagueType->name }}</x-table.td>
                    <x-table.td>{{ $leagues_guest->MarketType->name }}</x-table.td>
                    <x-table.td>{{ $leagues_guest->scoreType->name }}</x-table.td>
                    <x-table.td>{{ $leagues_guest->budget }}</x-table.td>
                    
                    <x-table.td class="flex justify-center">
                        {{-- {{ dd(auth()->user()->userSetting); }} --}}
                        <div class="flex items-center justify-end pr-6">
                            @if($receivedInvitation->trashed() || $leagues_guest->trashed())
                            <x-icon-btn class="opacity-40 bg-gray-500">
                                <i title="{{ __('You cannot select this league') }}" class="fa-solid fa-check"></i>
                            </x-icon-btn>
                            
                            @elseif($leagues_guest->id !== auth()->user()->userSetting->league_id)
                            <form action="{{ route('leagues.select', $receivedInvitation->league_id) }}" method="POST">
                                @csrf
                                @method('PUT') 
                                <x-button class="ml-4 w-8 h-8 flex justify-center">
                                    <i title="{{ __('Select') }}" class="fa-solid fa-check"></i>
                                </x-button>
                            </form>
                            @else
                            <x-icon-btn class="bg-green-500">
                                <i title="{{ __('Selected') }}" class="fa-solid fa-check"></i>
                            </x-icon-btn>
                            @endif
                            <x-icon-btn class="opacity-40 bg-orange-500">
                                <i title="{{ __('You cannot modify this league') }}" class="fa-solid fa-pen-to-square"></i>
                            </x-icon-btn>

                            <x-icon-btn class="opacity-40 bg-red-500">
                                <i title="{{ __('You cannot delete this league') }}" class="fa-solid fa-trash"></i>
                            </x-icon-btn>
                        </div>
                
                    </x-table.td>
                </tr>
                @endif
            @endforeach
        </x-table.table>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="pl-6 py-2 bg-white border-b border-gray-200">
            
                    {{ __("No League to display") }}
    
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
