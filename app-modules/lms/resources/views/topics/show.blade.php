<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $topic->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topic->series->count() }} series</p>
            </div>
            <form action="{{ route('topics.destroy', $topic) }}" method="POST" onsubmit="return confirm('Delete this topic?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1.5 text-sm bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($topic->series as $series)
                <a href="{{ route('series.show', $series) }}" class="block bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $series->title }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $series->url }}</p>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">No series in this topic.</div>
            @endforelse
        </div>
    </div>
</x-customer-frontend-layout::layout>
