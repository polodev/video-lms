@foreach (['status' => 'green', 'success' => 'green', 'error' => 'red', 'warning' => 'yellow'] as $key => $color)
    @if (session($key))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, {{ $color === 'red' ? 5000 : 4000 }})"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="fixed top-4 right-4 z-50 max-w-sm w-full bg-{{ $color }}-500 text-white px-6 py-4 rounded-lg shadow-lg"
        >
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium">{{ session($key) }}</p>
                <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif
@endforeach
