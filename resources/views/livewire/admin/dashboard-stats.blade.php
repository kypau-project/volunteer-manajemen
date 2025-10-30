<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Admin Dashboard Statistik") }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900">Total Relawan</h3>
                <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ $totalVolunteers }}</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900">Total Jam Kontribusi</h3>
                <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ number_format($totalHours, 2) }} Jam</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900">Total Acara</h3>
                <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ $totalEvents }}</p>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-xl font-semibold mb-4">Grafik Pendaftaran Relawan per Bulan</h3>
                <div class="relative h-96">
                    <canvas id="registrationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    // Load Chart.js library
    if (typeof Chart === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js';
        script.onload = () => {
            initChart();
        };
        document.head.appendChild(script);
    } else {
        initChart();
    }

    function initChart() {
        const ctx = document.getElementById('registrationChart');
        const chartData = @json($chartData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: chartData.data,
                    backgroundColor: 'rgba(79, 70, 229, 0.6)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endscript
@endscript
