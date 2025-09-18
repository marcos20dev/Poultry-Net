@extends('layouts.app')

@section('title', 'Dashboard Avanzado - Poultry Net')

@section('content')
    <div class="min-h-screen bg-gray-100 p-6" x-data>
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Avanzado</h1>
                <p class="text-gray-600">Monitoreo completo de tu operación avícola</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Buscar..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <i class="absolute left-3 top-2.5 text-gray-400" data-feather="search"></i>
                </div>
                <div class="bg-white p-2 rounded-full shadow-sm">
                    <i class="text-gray-600" data-feather="bell"></i>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-dashboard-card title="Total Detecciones" :value="$totalDetecciones" icon="activity" color="green"/>
            <x-dashboard-card title="Tiempo Promedio (min)" :value="number_format($tiempoPromedio, 2)" icon="clock" color="blue"/>
            <x-dashboard-card title="Gasto Total"
                              :value="'S/'.number_format($costos->total_gasto ?? 0, 2)"
                              :subValue="'Promedio: S/'.number_format($costos->promedio_gasto ?? 0, 2)"
                              icon="coins" color="red"/>
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-gray-500 text-sm font-medium">Satisfacción</h2>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($satisfaccionPromedio ?? 0, 1) }}/5</p>
                        <div class="flex items-center mt-2">
                            @for($i = 0; $i < floor($satisfaccionPromedio ?? 0); $i++)
                                <i class="text-yellow-500" data-feather="star" width="14" fill="currentColor"></i>
                            @endfor
                            @if(($satisfaccionPromedio ?? 0) - floor($satisfaccionPromedio ?? 0) >= 0.5)
                                <i class="text-yellow-500" data-feather="star" width="14" fill="currentColor"></i>
                            @endif
                            @for($i = 0; $i < 5 - ceil($satisfaccionPromedio ?? 0); $i++)
                                <i class="text-yellow-500" data-feather="star" width="14"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <i class="text-yellow-600" data-feather="star" width="24"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <x-chart-card title="Detecciones por Enfermedad" id="deteccionesChart" :labels="$deteccionesPorEnfermedad->keys()" :values="$deteccionesPorEnfermedad->values()" type="bar" />
            <x-chart-card title="Satisfacción por Puntuación" id="satisfaccionChart" :labels="$satisfaccionesPorPuntuacion->keys()" :values="$satisfaccionesPorPuntuacion->values()" type="doughnut" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <x-chart-card title="Tendencias de Tiempo" id="tiempoTrendChart" :labels="['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4']" :values="[3.2, 2.9, 2.7, 2.4]" type="line" />
            <x-chart-card title="Distribución de Costos" id="costosChart" :labels="['Alimentación', 'Medicamentos', 'Mano de Obra', 'Equipamiento']" :values="[45,25,20,10]" type="pie" />
            <x-chart-card title="Eficiencia por Sector" id="sectoresChart" :labels="['Sector A','Sector B','Sector C','Sector D']" :values="[85,75,90,65]" type="radar" />
        </div>

        <x-chart-card title="Historial de Detecciones (Últimos 30 días)" id="historialChart" :labels="range(1,30)" :values="[12, 15, 8, 14, 11, 17, 13, 10, 16, 12, 19, 15, 22, 18, 14, 16, 20, 17, 15, 13, 18, 21, 16, 19, 15, 12, 17, 20, 16, 14]" type="line" />

        <!-- Últimas Detecciones -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Últimas Detecciones</h2>
                <a href="#" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm flex items-center">
                    <i class="mr-2" data-feather="download" width="16"></i> Exportar
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enfermedad</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Confianza</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiempo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($ultimasDetecciones as $det)
                        <tr>
                            <td class="px-4 py-3">{{ $det->enfermedad }}</td>
                            <td class="px-4 py-3">{{ $det->sector->nombre }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 {{ $det->confianza > 80 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} text-xs rounded-full">{{ $det->confianza }}%</span>
                            </td>
                            <td class="px-4 py-3">{{ $det->tiempo_deteccion }} min</td>
                            <td class="px-4 py-3">{{ $det->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Botón para abrir modal -->
        <button @click="$dispatch('open-modal')" class="px-4 py-2 bg-blue-600 text-white rounded-lg mb-6">
            Abrir Formulario de Satisfacción
        </button>

        <!-- Modal de Satisfacción -->
        <div x-data="{ open: false }"
             x-show="open"
             x-on:open-modal.window="open = true"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity"
             style="display: none;">
            <div @click.away="open = false" class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-2xl">
                <h2 class="text-xl font-semibold mb-4">Formulario de Satisfacción</h2>

                <form action="{{ route('satisfaccion.store') }}" method="POST">
                    @csrf
                    @foreach($preguntas as $pregunta)
                        <div class="mb-4">
                            <label class="block font-medium mb-1">{{ $pregunta->numero }}. {{ $pregunta->texto }}</label>
                            <select name="respuestas[{{ $pregunta->id }}]" class="w-full border rounded-lg px-3 py-2">
                                <option value="">Selecciona</option>
                                <option value="5">Muy satisfecho (MS)</option>
                                <option value="4">Satisfecho (S)</option>
                                <option value="3">Neutral (N)</option>
                                <option value="2">Insatisfecho (I)</option>
                                <option value="1">Muy insatisfecho (MI)</option>
                            </select>
                        </div>
                    @endforeach
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
@endsection
