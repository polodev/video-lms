<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Videos</h1>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            @forelse ($completedProgress as $progress)
                @php $video = $progress->video; @endphp
                <a href="{{ route('video.show', $video) }}"
                   class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700/50 last:border-b-0">
                    <!-- Icon -->
                    @if ($video->isPdf())
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                    @else
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    @endif

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $video->file_name_without_extension }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $video->chapter->series->title }} &middot; {{ $video->chapter->title }}</p>
                    </div>

                    <!-- Completed date -->
                    <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0">{{ $progress->completed_at->diffForHumans() }}</span>
                </a>
            @empty
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    No completed videos yet. Start watching a series!
                </div>
            @endforelse
        </div>

        <div>{{ $completedProgress->links() }}</div>
    </div>
</x-customer-frontend-layout::layout>
