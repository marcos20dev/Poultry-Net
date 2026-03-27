@extends('layouts.app')

@section('title', "Historial de $sectorNombre")

@section('content')
    <div class="w-full min-h-screen bg-gray-100 p-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">📊 Historial de Detecciones - {{ $sectorNombre }}</h1>

        <div class="mb-6">
            <p class="text-gray-700 text-sm">Total de detecciones: <span class="font-bold">{{ $cantidad }}</span></p>
            <p class="text-gray-700 text-sm">Tiempo promedio: <span class="font-bold">{{ number_format($tiempo_promedio, 2) }}s</span></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($detecciones as $d)
                <div class="bg-white shadow rounded-2xl p-4 hover:shadow-lg transition">
                    <div class="mb-2">
                        <img src="{{ $d->imagen_url }}" alt="Imagen de detección" class="w-full h-48 object-cover rounded-xl mb-2">
                        <p class="text-gray-700 text-sm">🔍 Enfermedad: <span class="font-bold">{{ $d->enfermedad }}</span></p>
                        <p class="text-gray-700 text-sm">Confianza: <span class="font-bold">{{ $d->confianza }}%</span></p>
                        <p class="text-gray-700 text-sm">Tiempo de detección: <span class="font-bold">{{ number_format($d->tiempo_deteccion, 2) }}s</span></p>
                        @if($d->observaciones)
                            <p class="text-gray-700 text-sm">📝 Observaciones: <span class="font-bold">{{ $d->observaciones }}</span></p>
                        @endif
                        @if($d->recomendacion)
                            <p class="text-gray-700 text-sm">💡 Recomendación: <span class="font-bold">{{ $d->recomendacion }}</span></p>
                        @endif
                    </div>
                    <p class="text-gray-400 text-xs">📅 {{ $d->created_at->format('d/m/Y H:i') }}</p>
                </div>
            @empty
                <p class="text-gray-500">No hay detecciones registradas en este sector.</p>
            @endforelse
        </div>
    </div>
@endsection
