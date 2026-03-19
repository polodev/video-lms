<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $bookmark->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $bookmark->videos->count() }} videos</p>
            </div>
            <form action="{{ route('bookmarks.destroy', $bookmark) }}" method="POST" onsubmit="return confirm('Delete this bookmark?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1.5 text-sm bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            @forelse ($bookmark->videos as $video)
                <div class="flex items-center justify-between px-6 py-3 border-b border-gray-100 dark:border-gray-700/50 last:border-b-0">
                    <a href="{{ route('video.show', $video) }}" class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300 hover:text-orange-500">
                        @if ($video->isPdf())
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                        @else
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                        @endif
                        <span>{{ $video->file_name_without_extension }}</span>
                        <span class="text-xs text-gray-400">{{ $video->chapter->series->title }}</span>
                    </a>

                    <form action="{{ route('bookmarks.removeVideo', $bookmark) }}" method="POST">
                        @csrf
                        <input type="hidden" name="video_id" value="{{ $video->id }}">
                        <button type="submit" class="text-xs text-red-500 hover:underline">Remove</button>
                    </form>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">No videos in this bookmark.</div>
            @endforelse
        </div>
    </div>
</x-customer-frontend-layout::layout>
