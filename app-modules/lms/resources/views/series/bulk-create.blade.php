<x-customer-frontend-layout::layout>
    <div class="max-w-5xl mx-auto">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <a href="{{ route('series.index') }}" class="hover:text-orange-500">Series</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900 dark:text-white">Bulk Create</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Bulk Create Series</h1>

        <form action="{{ route('series.bulk-store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            @csrf

            <div>
                <label for="parent_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Parent Folder Path</label>
                <input type="text" name="parent_path" id="parent_path" value="{{ old('parent_path') }}" required
                       placeholder="/Users/polodev/Documents/courses"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                @error('parent_path') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Each subfolder under this path will be created as a separate series. The folder name becomes the series title.</p>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white font-medium rounded-md hover:bg-orange-600">Create Series</button>
                <a href="{{ route('series.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-customer-frontend-layout::layout>
