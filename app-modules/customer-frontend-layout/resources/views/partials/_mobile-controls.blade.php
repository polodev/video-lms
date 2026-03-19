<!-- Theme Toggle (Mobile) -->
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="p-2 text-gray-500 dark:text-gray-400 rounded-md">
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

<!-- Auth (Mobile) -->
@guest
    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300">Login</a>
@else
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center text-xs font-bold">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
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

<!-- Hamburger -->
<button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-gray-500 dark:text-gray-400 rounded-md">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
</button>
