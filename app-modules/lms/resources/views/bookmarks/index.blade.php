<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bookmarks</h1>
            <a href="{{ route('bookmarks.create') }}" class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600">+ New Bookmark</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse ($bookmarks as $bookmark)
                <a href="{{ route('bookmarks.show', $bookmark) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition">
                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $bookmark->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $bookmark->videos_count }} videos</p>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                    No bookmarks yet. <a href="{{ route('bookmarks.create') }}" class="text-orange-500 hover:underline">Create one</a>.
                </div>
            @endforelse
        </div>
    </div>
</x-customer-frontend-layout::layout>
