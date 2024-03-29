<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Modify your team') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('team.update', $team) }}">
                    @csrf
                    @method('PUT')
                    <div class="py-2">
                        <x-label for="name" :value="__('Team Name')" />
                        <x-input id="" class="block mt-1 w-full" type="text" name="name" :value="$team->name" required autofocus />
                    </div>

                    <div class="py-2">
                        <x-label for="stadium" :value="__('Stadium Name')" />
                        <x-input id="" class="block mt-1 w-full" type="text" name="stadium" :value="$team->stadium" required autofocus />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('team') }}" class="">
                            <x-tag class="bg-gray-500">
                                {{ __('Back') }}
                            </x-tag>
                        </a>
                        <x-button class="ml-4">
                            {{ __('Modify Team') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</x-app-layout>