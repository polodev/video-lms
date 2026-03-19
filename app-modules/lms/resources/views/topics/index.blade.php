<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Topics</h1>
            <a href="{{ route('topics.create') }}" class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600">+ New Topic</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($topics as $topic)
                <a href="{{ route('topics.show', $topic) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition">
                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $topic->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $topic->series_count }} series</p>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                    No topics yet. <a href="{{ route('topics.create') }}" class="text-orange-500 hover:underline">Create one</a>.
                </div>
            @endforelse
        </div>
    </div>
</x-customer-frontend-layout::layout>
