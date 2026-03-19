<div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gray-200 dark:border-gray-700 py-3">
    <div class="space-y-2">
        <a href="{{ route('series.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Series</a>
        <a href="{{ route('topics.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Topics</a>
        <a href="{{ route('bookmarks.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Bookmarks</a>
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Dashboard</a>
    </div>
</div>
