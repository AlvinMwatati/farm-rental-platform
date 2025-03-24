<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto" alt="Logo">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->is('/')">
                        {{ __('Home') }}
                    </x-nav-link>

                    <!-- Listings Dropdown -->
                    <div class="group relative">
                        <button class="px-4 py-2 text-gray-800 hover:text-gray-600 focus:outline-none">
                            Listings
                        </button>
                        <div class="absolute left-0 hidden w-48 bg-white shadow-md rounded mt-1 group-hover:block z-50">
                            <a href="{{ route('listings.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                Available Listings
                            </a>
                            @auth
                                <a href="{{ route('listings.my') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    My Listings
                                </a>
                                <a href="{{ route('listings.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    Post a Listing
                                </a>
                            @endauth
                        </div>
                    </div>

                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->is('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('chat.index')" :active="request()->is('chat')">
                            {{ __('Chat') }}
                        </x-nav-link>

                        <x-nav-link :href="route('forum')" :active="request()->is('forum')">
                            {{ __('Forum') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Right Side User Auth Links -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                {{ Auth::user()->name }}
                                <svg class="ml-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" 
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-nav-link :href="route('login')" :active="request()->is('login')">
                        {{ __('Login') }}
                    </x-nav-link>

                    <x-nav-link :href="route('register')" :active="request()->is('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                @endauth
            </div>
        </div>
    </div>
</nav>
