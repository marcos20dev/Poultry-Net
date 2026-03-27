@extends('layouts.app')

@section('title', 'Dashboard Avanzado - Poultry Net')

@section('content')
    <div class="min-h-screen bg-gray-100 p-6">


        <!-- Header Mejorado con Tailwind -->
        <div class="bg-gradient-to-r from-white to-emerald-50 rounded-2xl p-6 mb-8 border border-emerald-100 shadow-sm"
             x-data="{ openSurvey: false, rating: 0, comment: '', notifications: 3 }">

            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">

                <!-- Información Principal -->
                <div class="flex-1">
                    <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-800 to-emerald-600 bg-clip-text text-transparent">
                        Dashboard Avanzado
                    </h1>
                    <p class="text-gray-600 mt-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-500" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        Monitoreo completo de tu operación avícola
                    </p>
                </div>

                <!-- Acciones -->
                <div class="flex items-center space-x-3">
                    <!-- Búsqueda -->
                    <div class="relative hidden md:block">
                        <input type="text"
                               placeholder="Buscar lotes, pollos..."
                               class="pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white
                      focus:outline-none focus:ring-2 focus:ring-emerald-500
                      focus:border-transparent w-64 shadow-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-3 h-5 w-5 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                        </svg>
                    </div>

                    <!-- Botón Encuesta -->
                    <button @click="openSurvey = true"
                            class="px-5 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white
                   rounded-xl shadow-lg hover:shadow-xl hover:from-emerald-600 hover:to-green-700
                   transition-all duration-300 transform hover:-translate-y-0.5
                   flex items-center space-x-2 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                             viewBox="0 0 24 24">
                            <path d="M12 .587l3.668 7.431 8.2 1.179-5.934 5.778
                     1.402 8.174L12 18.896l-7.336 3.853
                     1.402-8.174L.132 9.197l8.2-1.179z"/>
                        </svg>
                        <span>Encuesta</span>
                    </button>
                </div>
            </div>

            <!-- Modal Encuesta -->

            <div x-show="openSurvey" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div @click.away="openSurvey = false"
                     class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl h-[90vh] flex flex-col
        transform transition-all duration-300 scale-95"
                     x-data="{
            ratings: {},
            comment: '',
            loading: false,
            enviarEncuesta() {
                if (Object.keys(this.ratings).length !== {{ $preguntasSatisfaccion->count() }}) {
                    alert('Por favor responde todas las preguntas.');
                    return;
                }

                this.loading = true;
                console.log('Enviando encuesta...', this.ratings, this.comment);

                fetch('{{ route('satisfaccion.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        ratings: this.ratings,
                        comment: this.comment
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('✅ Éxito:', data);
                    openSurvey = false;
                    this.ratings = {};
                    this.comment = '';
                })
                .catch(err => {
                    console.error('❌ Error:', err);
                    alert('Error al enviar encuesta.');
                })
                .finally(() => {
                    this.loading = false;
                });
            }
         }">

                    <!-- Header -->
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-t-2xl p-6 text-white flex justify-between items-center">
                        <h2 class="text-xl font-bold">Encuesta de Satisfacción</h2>
                        <button @click="openSurvey = false" class="hover:bg-white/20 p-1 rounded-full transition">✕</button>
                    </div>

                    <!-- Contenido -->
                    <div class="p-6 space-y-8 overflow-y-auto flex-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($preguntasSatisfaccion as $pregunta)
                                <div class="border border-gray-100 rounded-xl p-4 shadow-sm text-center">
                                    <p class="text-gray-700 mb-3 font-medium">{{ $pregunta->pregunta }}</p>

                                    <!-- Estrellas -->
                                    <div class="flex justify-center space-x-1">
                                        <template x-for="i in 5" :key="i">
                                            <button @click="ratings[{{ $pregunta->id }}] = i"
                                                    :class="i <= (ratings[{{ $pregunta->id }}] || 0) ? 'text-yellow-400' : 'text-gray-400'"
                                                    class="transition transform duration-200 p-2 text-2xl">★</button>
                                        </template>
                                    </div>

                                    <!-- Etiqueta -->
                                    <div class="mt-2">
                            <span x-show="ratings[{{ $pregunta->id }}] > 0"
                                  class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                  :class="{
                                      'bg-red-100 text-red-800': ratings[{{ $pregunta->id }}] <= 2,
                                      'bg-yellow-100 text-yellow-800': ratings[{{ $pregunta->id }}] === 3,
                                      'bg-green-100 text-green-800': ratings[{{ $pregunta->id }}] >= 4
                                  }">
                                <span x-text="
                                    ratings[{{ $pregunta->id }}] === 1 ? 'Muy insatisfecho' :
                                    ratings[{{ $pregunta->id }}] === 2 ? 'Insatisfecho' :
                                    ratings[{{ $pregunta->id }}] === 3 ? 'Neutral' :
                                    ratings[{{ $pregunta->id }}] === 4 ? 'Satisfecho' :
                                    ratings[{{ $pregunta->id }}] === 5 ? 'Muy satisfecho' : ''
                                "></span>
                            </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Comentarios -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comentarios adicionales</label>
                            <textarea x-model="comment"
                                      class="w-full border border-gray-200 rounded-xl p-3 resize-none
                             focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                      rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-4 border-t bg-gray-50 flex justify-end space-x-3 rounded-b-2xl">
                        <button @click="openSurvey = false; ratings = {}; comment = ''"
                                class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Cancelar
                        </button>

                        <button :disabled="loading"
                                @click="enviarEncuesta()"
                                class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition font-medium flex items-center">
                            <span x-show="!loading">Enviar</span>
                            <span x-show="loading" class="flex items-center space-x-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Cargando...</span>
                </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Breadcrumb -->
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500">
                <div class="flex items-center space-x-2">
            <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-medium">
                Usuario Activo
            </span>
                    <span>•</span>
                </div>

            </div>
        </div>

        <!-- Ocultar [x-cloak] por defecto -->
        <style>[x-cloak]{display:none !important}</style>






        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <x-dashboard-card title="Total Detecciones" :value="$totalDetecciones" icon="activity" color="green"/>
            <x-dashboard-card title="Tiempo Promedio (min)" :value="number_format($tiempoPromedio, 2)" icon="clock" color="blue"/>
            <x-dashboard-card title="Gasto Total"
                              :value="'S/'.number_format($costos->total_gasto ?? 0, 2)"
                              :subValue="'Promedio: S/'.number_format($costos->promedio_gasto ?? 0, 2)"
                              icon="coins" color="red"/>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            <x-chart-card
                title="Detecciones por Enfermedad"
                id="deteccionesChart"
                :labels="$deteccionesPorEnfermedad->keys()"
                :values="$deteccionesPorEnfermedad->values()"
                type="bar"
            />

            <x-chart-card
                title="Tendencias de Tiempo"
                id="tiempoTrendChart"
                :labels="['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4']"
                :values="[3.2, 2.9, 2.7, 2.4]"
                type="line"
            />

            <x-chart-card
                title="Eficiencia por Sector"
                id="sectoresChart"
                :labels="['Sector A','Sector B','Sector C','Sector D']"
                :values="[85,75,90,65]"
                type="radar"
            />
        </div>


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
        <!-- Notificación -->
        <div x-data="{ show: false, message: '' }"
             x-show="show"
             x-transition
             class="fixed bottom-6 right-6 bg-green-500 text-white px-4 py-2 rounded shadow-lg"
             x-text="message"
             x-cloak>
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
