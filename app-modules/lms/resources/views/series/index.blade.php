<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Series</h1>
            <div class="flex items-center gap-3">
                <a href="{{ route('series.hidden') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">Hidden</a>
                <a href="{{ route('series.create') }}" class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600">+ New Series</a>
            </div>
        </div>

        <!-- Search -->
        <form action="{{ route('series.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="query" value="{{ $search }}" placeholder="Search series..."
                   class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-orange-500 focus:border-orange-500">
            <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-gray-600 text-white text-sm rounded-md hover:bg-gray-700">Search</button>
        </form>

        <!-- Series Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($all_series as $series)
                <a href="{{ route('series.show', $series) }}" class="block bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $series->title }}</h3>

                    @if ($series->topics->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach ($series->topics as $topic)
                                <span class="px-2 py-0.5 text-xs bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 rounded-full">{{ $topic->title }}</span>
                            @endforeach
                        </div>
                    @endif

                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $series->url }}</p>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                    No series found. <a href="{{ route('series.create') }}" class="text-orange-500 hover:underline">Create one</a>.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div>{{ $all_series->links() }}</div>
    </div>
</x-customer-frontend-layout::layout>
