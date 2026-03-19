<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Series</h1>
            <div class="flex items-center gap-3">
                <a href="{{ route('series.hidden') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">Hidden</a>
                <a href="{{ route('series.bulk-create') }}" class="px-4 py-2 bg-gray-700 dark:bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-800 dark:hover:bg-gray-500">+ Bulk Series</a>
                <a href="{{ route('series.create') }}" class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600">+ New Series</a>
            </div>
        </div>

        <!-- Search -->
        <form action="{{ route('series.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="query" value="{{ $search }}" placeholder="Search series..."
                   class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-orange-500 focus:border-orange-500">
            @if ($activeTopic)
                <input type="hidden" name="topic" value="{{ $activeTopic }}">
            @endif
            <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-gray-600 text-white text-sm rounded-md hover:bg-gray-700">Search</button>
        </form>

        <!-- Topic Filter -->
        @if ($topics->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('series.index', request()->only('query')) }}"
                   class="px-3 py-1.5 text-sm rounded-full border {{ !$activeTopic ? 'bg-orange-500 text-white border-orange-500' : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    All
                </a>
                @foreach ($topics as $topic)
                    <a href="{{ route('series.index', array_merge(request()->only('query'), ['topic' => $topic->slug])) }}"
                       class="px-3 py-1.5 text-sm rounded-full border {{ $activeTopic === $topic->slug ? 'bg-orange-500 text-white border-orange-500' : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        {{ $topic->title }} <span class="text-xs opacity-75">({{ $topic->series_count }})</span>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Series List -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($all_series as $series)
                <div class="flex items-center gap-4 px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('series.show', $series) }}" class="block text-sm font-semibold text-gray-900 dark:text-white truncate hover:text-orange-500">{{ $series->title }}</a>
                        <p class="text-xs text-gray-400 dark:text-gray-500 font-mono truncate">{{ $series->url }}</p>
                        @if ($series->topics->isNotEmpty())
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach ($series->topics as $topic)
                                    <span class="px-2 py-0.5 text-xs bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 rounded-full">{{ $topic->title }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('series.show', $series) }}" class="px-3 py-1.5 text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600">View</a>
                        <a href="{{ route('series.edit', $series) }}" class="px-3 py-1.5 text-xs font-medium bg-orange-500 text-white rounded hover:bg-orange-600">Edit</a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    No series found. <a href="{{ route('series.create') }}" class="text-orange-500 hover:underline">Create one</a>.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div>{{ $all_series->links() }}</div>
    </div>
</x-customer-frontend-layout::layout>
