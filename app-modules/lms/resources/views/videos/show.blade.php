<x-customer-frontend-layout::layout>
    <div class="flex flex-col lg:flex-row gap-6" x-data="videoPage()">
        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            <!-- Player -->
            @if ($video->isVideo())
                <div class="bg-black rounded-lg overflow-hidden mb-4">
                    <video
                        id="video-player"
                        class="video-js vjs-default-skin w-full"
                        controls
                        preload="auto"
                        data-setup='{}'>
                        <source src="{{ route('video.stream', $video) }}" type="video/mp4">
                    </video>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-4">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">PDF Document</span>
                        <a href="{{ route('video.pdf', $video) }}" target="_blank" class="text-sm text-orange-500 hover:underline">Open in new tab</a>
                    </div>
                    <iframe src="{{ route('video.pdf', $video) }}" class="w-full" style="height: 70vh;"></iframe>
                </div>
            @endif

            <!-- Controls -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $video->file_name_without_extension }}</h2>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Prev/Next -->
                    @if ($prevVideo)
                        <a href="{{ route('video.show', $prevVideo) }}" class="px-3 py-1.5 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">&larr; Previous</a>
                    @endif
                    @if ($nextVideo)
                        <a href="{{ route('video.show', $nextVideo) }}" class="px-3 py-1.5 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Next &rarr;</a>
                    @endif

                    <!-- Mark Complete Toggle -->
                    <button @click="toggleComplete()" class="px-3 py-1.5 text-sm rounded-md"
                            :class="isCompleted ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'">
                        <span x-text="isCompleted ? 'Completed' : 'Mark Complete'"></span>
                    </button>

                    <!-- Add to Bookmark -->
                    @if ($bookmarks->isNotEmpty())
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="px-3 py-1.5 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">+ Bookmark</button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg border border-gray-200 dark:border-gray-600 z-50">
                                @foreach ($bookmarks as $bookmark)
                                    <form action="{{ route('bookmarks.addVideo', $bookmark) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="video_id" value="{{ $video->id }}">
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">{{ $bookmark->title }}</button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Back to Series -->
                    <a href="{{ route('series.show', $series) }}" class="ml-auto text-sm text-gray-500 dark:text-gray-400 hover:underline">Back to {{ $series->title }}</a>
                </div>
            </div>
        </div>

        <!-- Sidebar: Chapter Navigator -->
        <div class="lg:w-80 flex-shrink-0">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-4 max-h-[calc(100vh-6rem)] overflow-y-auto">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $series->title }}</h3>
                </div>

                @foreach ($chapters as $chapter)
                    <div x-data="{ open: {{ $chapter->id === $video->chapter_id ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700/50">
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate pr-2">{{ $chapter->title }}</span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-transition>
                            @foreach ($chapter->videos as $v)
                                <a href="{{ route('video.show', $v) }}"
                                   class="flex items-center gap-2 px-4 py-2 text-xs hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ $v->id === $video->id ? 'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400' : 'text-gray-600 dark:text-gray-400' }}">
                                    @if (!empty($userProgress[$v->id]))
                                        <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <div class="w-3.5 h-3.5 rounded-full border border-gray-300 dark:border-gray-600 flex-shrink-0"></div>
                                    @endif
                                    <span class="truncate">{{ $v->file_name_without_extension }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('head')
        <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
        <script>
            function videoPage() {
                return {
                    isCompleted: {{ $completed ? 'true' : 'false' }},
                    player: null,
                    progressInterval: null,

                    init() {
                        @if ($video->isVideo())
                            this.initPlayer();
                        @endif
                    },

                    initPlayer() {
                        const el = document.getElementById('video-player');
                        if (!el) return;

                        this.player = videojs(el, {
                            autoplay: true,
                            controls: true,
                            preload: 'auto',
                            playbackRates: [0.7, 1.0, 1.25, 1.5, 2.0, 2.5, 3.0],
                            fluid: true,
                        });

                        // Restore speed from localStorage
                        const savedSpeed = localStorage.getItem('user_speed') || 1.5;
                        setTimeout(() => {
                            this.player.playbackRate(parseFloat(savedSpeed));
                        }, 500);

                        // Persist speed changes
                        this.player.on('ratechange', function () {
                            localStorage.setItem('user_speed', this.playbackRate());
                        });

                        // Resume from last position
                        const resumeTime = {{ $watchedSeconds }};
                        if (resumeTime > 0) {
                            this.player.one('loadedmetadata', () => {
                                this.player.currentTime(resumeTime);
                            });
                        }

                        // Auto-advance on end
                        this.player.on('ended', () => {
                            this.saveProgress();
                            this.markVideoCompleted();
                            @if ($nextVideo)
                                window.location.href = '{{ route('video.show', $nextVideo) }}';
                            @endif
                        });

                        // Save progress every 15 seconds
                        this.progressInterval = setInterval(() => {
                            this.saveProgress();
                        }, 15000);
                    },

                    saveProgress() {
                        if (!this.player) return;
                        const currentTime = Math.floor(this.player.currentTime());
                        const duration = Math.floor(this.player.duration() || 0);

                        fetch('{{ route('progress.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                video_id: {{ $video->id }},
                                watched_seconds: currentTime,
                                total_seconds: duration,
                            }),
                        });
                    },

                    markVideoCompleted() {
                        this.isCompleted = true;
                        fetch('{{ route('progress.toggleComplete') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ video_id: {{ $video->id }} }),
                        });
                    },

                    toggleComplete() {
                        fetch('{{ route('progress.toggleComplete') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ video_id: {{ $video->id }} }),
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.isCompleted = data.completed;
                        });
                    },

                    destroy() {
                        if (this.progressInterval) clearInterval(this.progressInterval);
                        if (this.player) {
                            this.saveProgress();
                            this.player.dispose();
                        }
                    }
                };
            }
        </script>
    @endpush
</x-customer-frontend-layout::layout>
