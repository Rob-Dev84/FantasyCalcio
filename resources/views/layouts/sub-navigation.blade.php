<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-100">
    <!-- Secondary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                

                <!-- Sub Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    <!-- Drop down list of leagues -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('My Leagues') }}</div>
        
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
        
                            <x-slot name="content">
                                <!-- Leagues -->
                                    <x-dropdown-link :href="route('market')" :active="request()->routeIs('market')">
                                        {{ __('Leagues not found') }}
                                    </x-dropdown-link>
                                    <hr>
                                    <x-dropdown-link :href="route('leagues')" :active="request()->routeIs('leagues')">
                                        {{ __('Leagues management') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('leagues')" :active="request()->routeIs('leagues')">
                                        {{ __('Create new league') }}
                                    </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Drop down list of Team -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('My Team') }}</div>
        
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
        
                            <x-slot name="content">
                                <!-- Team -->
                                {{-- {{ dd(Auth::user()->team); }} --}}
                                @if (Auth::user()->team)
                                <x-dropdown-link class="opacity-30">
                                {{ __('Create Team') }}
                                </x-dropdown-link> 
                                @else
                                <x-dropdown-link :href="route('team.create')" :active="request()->routeIs('team.create')">
                                {{ __('Create Team') }}
                                </x-dropdown-link>                                    
                                @endif

                                <hr>
                                <x-dropdown-link :href="route('team')" :active="request()->routeIs('team')">
                                    {{ __('Team Management') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Drop down list of Invitations -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Invitations') }}
                                        {{-- Red spot to show user something new --}}
                                        @if (Auth::user()->receivedInvitations()->where('confirmed', NULL)->count())
                                        <sup class="w-2 h-2 inline-block rounded-full mt-0.5 bg-red-500"></sup>
                                        @endif
                                        
                                    </div>
        
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            
                            <x-slot name="content">
                                {{-- Invitations (only admin league can add friends) --}}
                                
                                {{-- Check if user_id of league selected is the same as user_id of League Admin --}}
                                {{-- {{ dd(Auth::user()->leagueOwnedBy->userSetting) }} --}}
                                @if (Auth::user()->leagueOwnedBy->userSetting)
                                <x-dropdown-link :href="route('invitations.create')" :active="request()->routeIs('invitations.create')">
                                    {{ __('Invite friends') }}
                                </x-dropdown-link>
                                @else
                                <x-dropdown-link class="opacity-30">
                                    {{ __('Invite friends') }}
                                </x-dropdown-link>
                                @endif
                                <hr>

                                @if (Auth::user()->userSetting->league_id || Auth::user()->recievedInvitation)
                                <x-dropdown-link :href="route('invitations')" :active="request()->routeIs('invitations')">
                                    {{ __('Invitation Management') }}
                                </x-dropdown-link>
                                @else
                                <x-dropdown-link class="opacity-30">
                                    {{ __('Invitations Management') }}
                                </x-dropdown-link>
                                @endif
                                <hr>

                                @if (Auth::user()->leagueOwnedBy->userSetting && Auth::user()->invitations()->onlyTrashed()->count())
                                <x-dropdown-link :href="route('invitations.trash')" :active="request()->routeIs('invitations/trash')">
                                    {{ __('Invitations Trash') }}
                                    {{-- @if (Auth::user()->invitations()->onlyTrashed()->count())
                                        <sup class="w-2 h-2 inline-block rounded-full mt-0.5 bg-red-500"></sup>
                                    @endif --}}
                                </x-dropdown-link>
                                @else
                                <x-dropdown-link class="opacity-30">
                                    {{ __('Invitations Trash') }}
                                </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>

             

                   
                </div>
            </div>

            <!-- League/Team Name -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 text-white">
                @if (Auth::user()->userSetting->league)
                {{ __('League: ') }}
                {{ Auth::user()->userSetting->league->name }} 
                @endif
                
                @if (Auth::user()->team)
                {{ __('Team: ') }}
                {{ Auth::user()->team->name }}    
                @endif
                
                
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Leagues not found') }}
            </x-responsive-nav-link>
            <hr>
            <x-responsive-nav-link :href="route('market')" :active="request()->routeIs('market')">
                {{ __('Create new league') }}
            </x-responsive-nav-link>
            <hr>
            <x-responsive-nav-link :href="route('invitations')" :active="request()->routeIs('invitations')">
                {{ __('Invitations') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('invitations.create')" :active="request()->routeIs('invitations.create')">
                {{ __('invite-friends') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
