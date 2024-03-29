<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team management') }}
        </h2>
    </x-slot>



    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{ __('My Team') }}

                </div>
            </div>
        </div>
    </div>

    
    <div class="pt-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="pl-6 py-2 bg-white border-b border-gray-200">
                    <ul>
                        <li class="flex items-center justify-between">
                            {{-- @if($league->team->count() > 0) --}}
                            {{-- {{ dd(auth()->user()->team); }} --}}
                            @if(auth()->user()->team)
                                <div>
                                    {{ auth()->user()->team->name }}
                                    {{ '-' }}
                                    {{ __('Stadium:') }}
                                    {{ auth()->user()->team->stadium }} 
                                </div>
                                <div class="flex items-center justify-end pr-6">
                                    
                                    {{-- <a href="{{ route('team.edit', $team) }}">
                                        <x-button class="ml-4">
                                            {{ __('Modify') }}
                                        </x-button>

                                        <x-button class="ml-4 w-8 h-8 flex justify-center bg-orange-500">
                                            <i title="{{ __('Modify') }}" class="fa-solid fa-pen-to-square"></i>
                                        </x-button>
                                    </a> --}}
                                  
                                    <form action="{{ route('team.edit', auth()->user()->team) }}" method="POST">
                                        @csrf
                                        @method('GET') 
                                        <x-button class="ml-4 w-8 h-8 flex justify-center bg-orange-500">
                                            <i title="{{ __('Modify') }}" class="fa-solid fa-pen-to-square"></i>
                                        </x-button>
                                    </form>
                                    
                                    {{-- Delete - for only if team hasn't deployed module --}}
                                    @if (!auth()->user()->team->module)
                                        <form action="{{ route('team.destroy', auth()->user()->team) }}" method="POST">
                                            @csrf
                                            @method('DELETE') 
                                            <x-button class="ml-4 w-8 h-8 flex justify-center bg-red-500">
                                                <i title="{{ __('Delete') }}" class="fa-solid fa-trash"></i>
                                            </x-button>
                                        </form>
                                    @endif
                                    
                                </div>
                        
                            @else
                                <div>{{ __('Create you team') }}</div>
                                <x-dropdown-link :href="route('team.create', [auth()->user()->UserSetting->league])">
                                    {{ __('Create') }}
                                </x-dropdown-link>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
