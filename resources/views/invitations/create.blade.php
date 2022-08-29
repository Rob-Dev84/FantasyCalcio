<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invite friends to your League ') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
    
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    
                    <form method="POST" action="{{ route('invitation.store') }}">
                        @csrf
                        <!-- Email Name -->
                        <div>
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="" class="border-2 block mt-1 w-full" type="text" name="email" :value="old('email')" />
                            
                            {{-- @error('email')
                                {{ $message }}
                            @enderror --}}
                        </div>
    
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Invite') }}
                            </x-button>
                        </div>
                    </form>
    
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>