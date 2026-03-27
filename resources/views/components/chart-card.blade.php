@props(['id', 'title', 'labels', 'values', 'type'])

<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
    </div>
    <div class="w-full h-64"> <!-- Ajusta h-64 para cambiar altura -->
        <canvas id="{{ $id }}"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('{{ $id }}').getContext('2d');
            new Chart(ctx, {
                type: '{{ $type }}',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: '{{ in_array($type, ["line","bar"]) ? "Valores" : "" }}',
                        data: {!! json_encode($values) !!},
                        backgroundColor: ['#2c6e49','#4c956c','#38b000','#f9a620','#e63946','#4361ee'],
                        borderColor: '#2c6e49',
                        borderWidth: 1,
                        fill: {{ $type === 'line' ? 'true' : 'false' }},
                        tension: 0.3,
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Esto hace que el canvas respete el alto del contenedor
                    plugins: {
                        legend: { display: {{ in_array($type, ['doughnut', 'pie']) ? 'true' : 'false' }} }
                    }
                }
            });
        });
    </script>
</div>
