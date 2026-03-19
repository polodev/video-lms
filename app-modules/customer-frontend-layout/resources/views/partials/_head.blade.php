<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? config('app.name', 'Video LMS') }}</title>

<!-- Theme Manager -->
<script>
    (function() {
        const appearance = localStorage.getItem('appearance') || 'system';
        if (appearance === 'dark' || (appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>

<!-- Hide Alpine elements until loaded -->
<style>[x-cloak] { display: none !important; }</style>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles

@stack('styles')
@stack('head')
