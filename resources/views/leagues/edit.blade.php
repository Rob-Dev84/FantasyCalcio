<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modify League') }}
        </h2>
    </x-slot>



    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{ __("As League Admin, you are able to modify some parameters") }}

                </div>
            </div>
        </div>
    </div>

    
    <div class="pt-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('league.update', $league) }}">
                        @csrf
                        @method('PUT')
                        <!-- League Name -->
                        <div>
                            <x-label for="name" :value="__('League Name')" />

                            <x-input id="" class="block mt-1 w-full" type="text" name="name" :value="$league->name" autofocus />
                        </div>

                        <div class="flex justify-between">
                            <!-- Legue Selection -->
                            <div class="mt-4">
                                <x-label for="league" :value="__('Select your League')" />
                                <div class="flex items-center">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="1" checked="{{ ($league->league_type_id === 1) ? 'checked' : '' }}" />
                                    <x-label for="league_type" :value="__('Serie A')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="2" disabled />
                                    <x-label for="league_type" :value="__('Premier League')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="3" disabled />
                                    <x-label for="league_type" :value="__('LaLiga')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="4" disabled />
                                    <x-label for="league_type" :value="__('Ligue 1')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="league_type" :value="5" disabled />
                                    <x-label for="league_type" :value="__('Bundesliga')" />
                                </div>
                                
                                {{-- <x-input id="league_eng" class="block mt-1" type="radio" name="league_eng" :value="old('league_eng')" disabled/> --}}
                        
                            </div>

                            <!-- Markert type -->
                            <div class="mt-4">
                                <x-label for="market" :value="__('Type of market')" />
                                <div class="flex items-center">
                                    <x-input id="market_type" class="block mr-1" type="radio" name="market_type" :value="1" checked="{{ ($league->market_type_id === 1) ? 'checked' : '' }}" />
                                    <x-label for="market_type" :value="__('Free')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="market_type" :value="2" disabled />
                                    <x-label for="market_type" :value="__('Auction')" />
                                </div>
                                
                                {{-- <x-input id="league_eng" class="block mt-1" type="radio" name="league_eng" :value="old('league_eng')" disabled/> --}}
                        
                            </div>

                            <!-- Score type -->
                            <div class="mt-4">
                                <x-label for="score_type" :value="__('Select your League')" />
                                <div class="flex items-center">
                                    <x-input id="" class="block mr-1" type="radio" name="score_type" :value="1" checked="{{ ($league->score_type_id === 1) ? 'checked' : '' }}" />
                                    <x-label for="score_type" :value="__('Points')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="score_type" :value="2" disabled />
                                    <x-label for="score_type" :value="__('Formula one')" />
                                </div>
                                <div class="flex items-center opacity-40">
                                    <x-input id="" class="block mr-1" type="radio" name="score_type" :value="3" disabled />
                                    <x-label for="score_type" :value="__('fixtures')" />
                                </div>
                                
                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="mt-4">
                            <x-label for="budget" :value="__('League Budget')" />

                            <x-input id="budget" class="block mt-2 w-full" type="number" name="budget" :value="$league->budget" autofocus />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Modify League') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
