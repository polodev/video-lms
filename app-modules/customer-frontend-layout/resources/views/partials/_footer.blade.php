<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ config('app.name') }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Personal video learning management system for watching downloaded courses.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('series.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Series</a></li>
                    <li><a href="{{ route('topics.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Topics</a></li>
                    <li><a href="{{ route('bookmarks.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Bookmarks</a></li>
                </ul>
            </div>

            <!-- Account -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Account</h3>
                <ul class="space-y-2">
                    @guest
                        <li><a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Register</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Dashboard</a></li>
                        <li><a href="{{ route('profile') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Profile</a></li>
                    @endguest
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</footer>
