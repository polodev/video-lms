<nav class="hidden md:flex items-center space-x-6">
    <a href="{{ route('series.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('series.index') ? 'text-orange-600 dark:text-orange-400' : '' }}">
        Series
    </a>
    <a href="{{ route('topics.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('topics.*') ? 'text-orange-600 dark:text-orange-400' : '' }}">
        Topics
    </a>
    <a href="{{ route('bookmarks.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('bookmarks.*') ? 'text-orange-600 dark:text-orange-400' : '' }}">
        Bookmarks
    </a>
    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('dashboard') ? 'text-orange-600 dark:text-orange-400' : '' }}">
        Dashboard
    </a>

    <!-- Theme Dropdown -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 rounded-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </button>
        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-36 bg-white dark:bg-gray-700 rounded-md shadow-lg border border-gray-200 dark:border-gray-600 z-50">
            <button @click="setAppearance('light'); open = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-t-md">Light</button>
            <button @click="setAppearance('dark'); open = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Dark</button>
            <button @click="setAppearance('system'); open = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-b-md">System</button>
        </div>
    </div>

    <!-- Auth Links -->
    @guest
        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Login</a>
        <a href="{{ route('register') }}" class="text-sm font-medium bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">Register</a>
    @else
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </span>
                {{ Auth::user()->name }}
            </button>
            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg border border-gray-200 dark:border-gray-600 z-50">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-t-md">Dashboard</a>
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-b-md">Logout</button>
                </form>
            </div>
        </div>
    @endguest
</nav>
