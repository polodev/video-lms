<header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('series.index') }}" class="text-xl font-bold text-gray-900 dark:text-white">
                {{ config('app.name', 'Video LMS') }}
            </a>

            <!-- Mobile Controls -->
            <div class="flex items-center gap-2 md:hidden">
                @include('customer-frontend-layout::partials._mobile-controls')
            </div>

            <!-- Desktop Navigation -->
            @include('customer-frontend-layout::partials._desktop-navigation')
        </div>

        <!-- Mobile Menu -->
        @include('customer-frontend-layout::partials._mobile-menu')
    </div>
</header>
