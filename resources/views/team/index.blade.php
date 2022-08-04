<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team management') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    My Team

                </div>
            </div>
        </div>
    </div>

    
                <div class="py-2">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="pl-6 py-2 bg-white border-b border-gray-200">
                                <ul>
                                    <li class="flex items-center justify-between">
                                        {{-- @if($league->team->count() > 0) --}}
                                        @if($team)

                                        <div>
                                        {{ $team->name }}
                                        {{ '-' }}
                                        {{ __('Stadium:') }}
                                        {{ $team->stadium }} 
                                        </div>
                                        <div class="flex items-center justify-end pr-6">
                                            {{-- <form action="{{ route('team.update', $team) }}" method="POST">
                                                @csrf
                                                @method('PUT') 
                                                <x-button class="ml-4">
                                                    {{ __('Modify') }}
                                                </x-button>
                                            </form> --}}
                                            <a href="{{ route('team.edit', $team) }}">
                                                <x-button class="ml-4">
                                                    {{ __('Modify') }}
                                                </x-button>
                                            </a>
                                            
                                            {{-- Delete --}}
                                            <form action="{{ route('team.destroy', $team) }}" method="POST">
                                                @csrf
                                                @method('DELETE') 
                                                <x-button class="ml-4 bg-red-500">
                                                    {{ __('Delete') }}
                                                </x-button>
                                            </form>
                                        </div>
                                    
                                        @else
                                        <div>{{ __('Create you team') }}</div>
                                        <x-dropdown-link :href="route('team.create')">
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
