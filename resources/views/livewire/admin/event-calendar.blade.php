<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Kalender Acara") }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    // Load FullCalendar library and dependencies
    const loadFullCalendar = () => {
        const links = [
            'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css'
        ];
        const scripts = [
            'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'
        ];

        let loadedCount = 0;
        const totalToLoad = links.length + scripts.length;

        const checkCompletion = () => {
            loadedCount++;
            if (loadedCount === totalToLoad) {
                initCalendar();
            }
        };

        links.forEach(href => {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = href;
            link.onload = checkCompletion;
            document.head.appendChild(link);
        });

        scripts.forEach(src => {
            const script = document.createElement('script');
            script.src = src;
            script.onload = checkCompletion;
            document.head.appendChild(script);
        });
    };

    const initCalendar = () => {
        const calendarEl = document.getElementById('calendar');
        const events = @json($events);

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: events,
            eventClick: function(info) {
                if (info.event.url) {
                    window.open(info.event.url);
                    info.jsEvent.preventDefault(); // don't follow the URL
                }
            },
            locale: 'id', // Set locale to Indonesian
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari'
            },
            allDayText: 'Sepanjang Hari',
        });

        calendar.render();
    };

    loadFullCalendar();
</script>
@endscript

