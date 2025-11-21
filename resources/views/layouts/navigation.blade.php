<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Brand -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center text-gray-800 hover:text-gray-900">
                    <i class="fa-solid fa-calendar-days fa-2x text-primary me-2"></i>
                    <span class="font-semibold text-xl">Daily App</span>
                </a>
            </div>
            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:space-x-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                    <i class="fa-solid fa-house me-2"></i>
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('daily-entries.calendar') }}" class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                    <i class="fa-regular fa-calendar me-2"></i>
                    {{ __('บันทึกประจำวัน') }}
                </a>
            </div>
            <!-- Right Side (User & Dark Mode) -->
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <button id="dark-mode-toggle" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <i class="fa-solid fa-moon fa-lg"></i>
                </button>
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm focus:outline-none">
                        <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}" />
                        <span class="ml-2 text-gray-800 hidden sm:inline">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down ml-1"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg py-1 z-20">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fa-regular fa-user me-2"></i> {{ __('Profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fa-solid fa-power-off me-2"></i> {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex sm:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-primary text-base font-medium text-primary bg-gray-50">
                <i class="fa-solid fa-house me-2"></i> {{ __('Dashboard') }}
            </a>
            <a href="{{ route('daily-entries.calendar') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300">
                <i class="fa-regular fa-calendar me-2"></i> {{ __('บันทึกประจำวัน') }}
            </a>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}" />
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">
                    <i class="fa-regular fa-user me-2"></i> {{ __('Profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100">
                        <i class="fa-solid fa-power-off me-2"></i> {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
