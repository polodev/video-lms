<x-customer-frontend-layout::layout>
    <div class="max-w-md mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Forgot Password</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Enter your email to receive a password reset link</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md">
                        <p class="text-sm text-green-600 dark:text-green-300">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               placeholder="your@email.com" required autocomplete="email"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Send Password Reset Link
                    </button>
                </form>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}"
                       class="text-orange-600 hover:text-orange-700 hover:underline font-medium">Back to login</a>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>
