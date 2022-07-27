<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a league') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- League Name -->
                        <div>
                            <x-label for="name" :value="__('League Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- Legue Selection -->
                        <div class="mt-4">
                            <x-label for="league" :value="__('Select your League')" />

                            <x-input id="league" class="block mt-1 w-full" type="text" name="league" :value="old('league')" required autofocus />
                        </div>

                        <!-- Markert type -->
                        <div class="mt-4">
                            <x-label for="market" :value="__('Type of markert')" />

                            <x-input id="market" class="block mt-1 w-full" type="text" name="market" :value="old('market')" required autofocus />
                        </div>

                        <!-- Score type -->
                        <div class="mt-4">
                            <x-label for="score" :value="__('Type of score')" />

                            <x-input id="score" class="block mt-1 w-full" type="text" name="score" :value="old('score')" required autofocus />
                        </div>
                        
                        

                        

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <x-button class="ml-4">
                                {{ __('Register') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
