<x-customer-frontend-layout::layout>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>

        @if ($enrolledSeries->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't started watching any series yet.</p>
                <a href="{{ route('series.index') }}" class="px-6 py-2 bg-orange-500 text-white font-medium rounded-md hover:bg-orange-600">Browse Series</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($enrolledSeries as $enrollment)
                    <a href="{{ route('series.show', $enrollment->series) }}" class="block bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $enrollment->series->title }}</h3>

                        <!-- Progress Bar -->
                        <div class="mb-2">
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                <span>{{ $enrollment->progress['completed'] }}/{{ $enrollment->progress['total'] }} completed</span>
                                <span>{{ $enrollment->progress['percentage'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full transition-all" style="width: {{ $enrollment->progress['percentage'] }}%"></div>
                            </div>
                        </div>

                        <p class="text-xs text-gray-400 dark:text-gray-500">Enrolled {{ $enrollment->enrolled_at->diffForHumans() }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-customer-frontend-layout::layout>
