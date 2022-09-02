<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leagues trashed') }}
        </h2>
    </x-slot>

    @if ($leagues->count())
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                    <div>
                    {{ __('As League Admin, you have') }} {{ $leagues->count() }} {{ Str::plural('league', $leagues->count()) }} {{ __(' in your trash.') }} 
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($leagues as $league)
    <ol>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pl-6 py-2 bg-white border-b border-gray-200">
                
                        <li class="flex items-center justify-between">
                            <div>
                            {{ $league->name }} 
                            </div>
                            <div class="flex items-center justify-end pr-6">

                                {{-- OK --}}
                                <form action="{{ route('league.restore', $league) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <x-button class="ml-4">
                                        {{ __('Restore') }}
                                    </x-button>
                                </form>

                                {{-- To fix: Force Delete --}}
                                <form action="{{ route('league.forceDelete', $league) }}" method="POST">
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
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                        <div>

                        {{ __('Your trash is empty') }}
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </ol>

    
</x-app-layout>
