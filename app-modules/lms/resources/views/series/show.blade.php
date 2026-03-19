<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('series.index') }}" class="hover:text-orange-500">Series</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900 dark:text-white">{{ $series->title }}</span>
        </nav>

        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $series->title }}</h1>

                    @if ($series->description)
                        <p class="text-gray-600 dark:text-gray-400 mb-3">{{ $series->description }}</p>
                    @endif

                    @if ($series->topics->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach ($series->topics as $topic)
                                <a href="{{ route('topics.show', $topic) }}" class="px-2 py-0.5 text-xs bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 rounded-full hover:bg-orange-200 dark:hover:bg-orange-900/50">{{ $topic->title }}</a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Progress -->
                    <div class="flex items-center gap-3">
                        <div class="flex-1 max-w-xs bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $progress['percentage'] }}%"></div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $progress['completed'] }}/{{ $progress['total'] }} ({{ $progress['percentage'] }}%)</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <form action="{{ route('series.scan', $series) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600">Scan Folder</button>
                    </form>
                    <a href="{{ route('series.edit', $series) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Edit</a>
                </div>
            </div>
        </div>

        <!-- Chapters Accordion -->
        <div class="space-y-3" x-data="{ openChapter: {{ $series->chapters->first()?->id ?? 'null' }} }">
            @foreach ($series->chapters as $chapter)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button @click="openChapter = openChapter === {{ $chapter->id }} ? null : {{ $chapter->id }}"
                            class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="openChapter === {{ $chapter->id }} ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $chapter->title }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $chapter->videos->count() }} files)</span>
                        </div>
                    </button>

                    <div x-show="openChapter === {{ $chapter->id }}" x-transition class="border-t border-gray-200 dark:border-gray-700">
                        @foreach ($chapter->videos as $video)
                            <a href="{{ route('video.show', $video) }}"
                               class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700/50 last:border-b-0">
                                <!-- Completion checkmark -->
                                @if (!empty($userProgress[$video->id]))
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 flex-shrink-0"></div>
                                @endif

                                <!-- File type icon -->
                                @if ($video->isPdf())
                                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                    </svg>
                                @endif

                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ $video->file_name_without_extension }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        @if ($series->chapters->isEmpty())
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                No chapters yet. Click "Scan Folder" to generate chapters and videos from the course folder.
            </div>
        @endif
    </div>
</x-customer-frontend-layout::layout>
