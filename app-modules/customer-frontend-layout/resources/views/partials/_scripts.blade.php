@livewireScripts

<script>
    function setAppearance(mode) {
        localStorage.setItem('appearance', mode);
        if (mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    // Handle session expired (419)
    document.addEventListener('livewire:init', () => {
        Livewire.hook('request', ({ fail }) => {
            fail(({ status }) => {
                if (status === 419) {
                    if (confirm('Your session has expired. Would you like to refresh the page?')) {
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>

@stack('scripts')
