<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('topics.index') }}" class="hover:text-orange-500">Topics</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900 dark:text-white">{{ $topic->title }}</span>
        </nav>

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

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($topic->series as $series)
                <div class="flex items-center gap-4 px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('series.show', $series) }}" class="block text-sm font-semibold text-gray-900 dark:text-white truncate hover:text-orange-500">{{ $series->title }}</a>
                        <p class="text-xs text-gray-400 dark:text-gray-500 font-mono truncate">{{ $series->url }}</p>
                        @if ($series->topics->isNotEmpty())
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach ($series->topics as $t)
                                    <span class="px-2 py-0.5 text-xs bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 rounded-full">{{ $t->title }}</span>
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
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">No series in this topic.</div>
            @endforelse
        </div>
    </div>
</x-customer-frontend-layout::layout>
