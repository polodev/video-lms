<x-customer-frontend-layout::layout>
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create Topic</h1>

        <form action="{{ route('topics.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-orange-500 focus:border-orange-500">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white font-medium rounded-md hover:bg-orange-600">Create</button>
                <a href="{{ route('topics.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-customer-frontend-layout::layout>
