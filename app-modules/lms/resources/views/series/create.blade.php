<x-customer-frontend-layout::layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create Series</h1>

        <form action="{{ route('series.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Folder Path</label>
                <input type="text" name="url" id="url" value="{{ old('url') }}" required placeholder="/Users/polodev/Documents/courses/..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (optional)</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-orange-500 focus:border-orange-500">{{ old('description') }}</textarea>
            </div>

            @if ($topics->isNotEmpty())
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Topics</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($topics as $topic)
                            <label class="flex items-center gap-1.5 px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-full cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input type="checkbox" name="topic_ids[]" value="{{ $topic->id }}" class="rounded text-orange-500 focus:ring-orange-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $topic->title }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white font-medium rounded-md hover:bg-orange-600">Create</button>
                <a href="{{ route('series.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-customer-frontend-layout::layout>
