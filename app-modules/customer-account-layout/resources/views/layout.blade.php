<x-customer-frontend-layout::layout>
    <div class="flex flex-col lg:flex-row gap-8" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            Account Menu
        </button>

        @include('customer-account-layout::partials._sidebar')

        <main class="flex-1">
            @include('customer-frontend-layout::partials._status-message')
            {{ $slot }}
        </main>
    </div>
</x-customer-frontend-layout::layout>
