
{{-- Header --}}
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Lotes en {{ $sector->nombre }}</h1>
            <p class="text-gray-600 mt-1">Información general y análisis de lotes avícolas</p>
        </div>
        <a href="{{ route('sectores.index') }}"
           class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition flex items-center gap-2 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a sectores
        </a>
    </div>
    <div class="border-b border-gray-200 mt-4"></div>
</div>

{{-- Dashboard superior --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
        <div class="p-3 bg-blue-50 rounded-full mb-3">👨‍🌾</div>
        <p class="text-gray-500 text-sm font-medium">Cantidad de pollos</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $lotes->sum('cantidad_pollos') }}</h2>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
        <div class="p-3 bg-green-50 rounded-full mb-3">⏳</div>
        <p class="text-gray-500 text-sm font-medium">Edad promedio (días)</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ round($lotes->avg('edad_dias')) }}</h2>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
        <div class="p-3 bg-purple-50 rounded-full mb-3">📈</div>
        <p class="text-gray-500 text-sm font-medium">Etapa principal</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-1">
            {{ $lotes->groupBy('etapa')->sortByDesc(fn($g)=>$g->count())->keys()->first() ?? '-' }}
        </h2>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
        <div class="p-3 bg-amber-50 rounded-full mb-3">📅</div>
        <p class="text-gray-500 text-sm font-medium">Último ingreso</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-1">
            {{ $lotes->max('fecha_ingreso') ? \Carbon\Carbon::parse($lotes->max('fecha_ingreso'))->format('d/m/Y') : '-' }}
        </h2>
    </div>
</div>

{{-- Lotes individuales --}}
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Lotes individuales</h2>
        <span class="text-sm text-gray-500">{{ $lotes->count() }} lotes encontrados</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($lotes as $lote)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800">{{ $lote->nombre }}</h3>
                <p class="text-gray-500 text-sm">🐔 Pollos: {{ $lote->cantidad_pollos }}</p>
                <p class="text-gray-500 text-sm">⏳ Edad: {{ $lote->edad_dias }} días</p>
                <p class="text-gray-500 text-sm">📅 Ingreso: {{ \Carbon\Carbon::parse($lote->fecha_ingreso)->format('d/m/Y') }}</p>
                <p class="text-gray-500 text-sm">📊 Etapa: {{ $lote->etapa }}</p>
            </div>
        @empty
            <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-sm border border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h.01M15 10h.01M9.172 16.172a4 4 0 015.656 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="mt-3 text-gray-500">No hay lotes en este sector.</p>
            </div>
        @endforelse
    </div>
</div>
