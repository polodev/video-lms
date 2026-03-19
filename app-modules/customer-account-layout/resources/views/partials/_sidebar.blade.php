<aside
    x-show="sidebarOpen || window.innerWidth >= 1024"
    x-transition
    @resize.window="sidebarOpen = window.innerWidth >= 1024 ? true : sidebarOpen"
    class="lg:w-64 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6"
>
    <!-- User Info -->
    <div class="text-center mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
        <div class="w-16 h-16 rounded-full bg-orange-500 text-white flex items-center justify-center text-xl font-bold mx-auto mb-3">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
    </div>

    <!-- Navigation -->
    <nav class="space-y-1">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('bookmarks.index') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('bookmarks.*') ? 'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            Bookmarks
        </a>
        <a href="{{ route('profile') }}"
           class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('profile') ? 'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profile
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </nav>
</aside>
