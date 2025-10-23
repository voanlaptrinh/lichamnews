<script defer src="{{ asset('js/base-picker.js?v=3.5') }}"></script>
<script defer src="{{ asset('js/home.js?v=3.5') }}"></script>
<script>
    // Inline critical initialization
    window.addEventListener('DOMContentLoaded', () => {
        // Wait for deferred scripts to load
        if (typeof LunarCalendarApp !== 'undefined') {
            const lunarApp = new LunarCalendarApp({
                currentYear: {{ $yy }},
                currentMonth: {{ $mm }},
                currentDay: {{ $dd }},
                ajaxUrl: '{{ route('lunar.detail.ajax') }}'
            });
            lunarApp.init();
        } else {
            // Fallback: wait for scripts
            setTimeout(() => {
                if (typeof LunarCalendarApp !== 'undefined') {
                    const lunarApp = new LunarCalendarApp({
                        currentYear: {{ $yy }},
                        currentMonth: {{ $mm }},
                        currentDay: {{ $dd }},
                        ajaxUrl: '{{ route('lunar.detail.ajax') }}'
                    });
                    lunarApp.init();
                }
            }, 100);
        }
    });
</script>
