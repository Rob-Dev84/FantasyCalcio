<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invitations trashed') }}
        </h2>
    </x-slot>

{{-- Visible only to the league Admin --}}

    {{-- @if (Auth::user()->id === $league->user_id)  --}}
    
    @if (Auth::user()->leagueOwnedBy->userSetting) {{-- Here we check if 'id_user' form the league table matches the 'user_id' from userSetting table --}}
    
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">                 
                    <div>
                    {{ __('As League Admin, you have') }} {{ $invitations->count() }} {{ Str::plural('friend', $invitations->count()) }} {{ __(' in your trash.') }} 
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- loop trashed here --}}
        @if($invitations)

        @foreach ($invitations as $invitation)
        {{-- {{ dd($recievedInvitation) }} --}}
        <div class="pt-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pl-6 py-2 bg-white border-b border-gray-200">
                        <ul>
                            <li class="flex items-center justify-between">
                                <div>
                                {{ $invitation->email }}
                                </div>
                                <div class="flex items-center justify-end pr-6">
                                    <form action="{{ route('invitation.restore', $invitation) }}" method="POST">
                                        @csrf
                                        @method('PUT') 
                                        <x-button class="ml-4 bg-green-500">
                                            {{ __('Restore') }}
                                        </x-button>
                                    </form>

                                    <form action="{{ route('invitation.forceDelete', $invitation) }}" method="POST">
                                        @csrf
                                        @method('DELETE') 
                                        <x-button class="ml-4 bg-red-500">
                                            {{ __('Delete') }}
                                        </x-button>
                                    </form>
                                </div>
                                
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        @endif
    @endif



    
</x-app-layout>
