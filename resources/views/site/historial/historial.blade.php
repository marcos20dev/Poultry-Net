@extends('layouts.app')

@section('title', 'Historial Avanzado de Detecciones')

@section('content')
    <div class="w-full min-h-screen bg-gray-100 p-6">

        <h1 class="text-2xl font-bold text-gray-700 mb-6">📊 Historial de Detecciones por Sector</h1>

        {{-- KPIs generales --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow rounded-2xl p-4">
                <p class="text-sm text-gray-500">💵 Inversión Inicial</p>
                <p class="text-2xl font-bold text-blue-600">S/ {{ number_format($inversion, 2) }}</p>
            </div>
            <div class="bg-white shadow rounded-2xl p-4">
                <p class="text-sm text-gray-500">🔍 Costo por Detección</p>
                <p class="text-2xl font-bold text-blue-600">S/ {{ number_format($gastoDet, 2) }}</p>
            </div>
            <div class="bg-white shadow rounded-2xl p-4">
                <p class="text-sm text-gray-500">📈 Total de Detecciones</p>
                <p class="text-2xl font-bold text-green-600">{{ $totalDet }}</p>
            </div>
            <div class="bg-white shadow rounded-2xl p-4">
                <p class="text-sm text-gray-500">💰 Retorno Generado</p>
                <p class="text-2xl font-bold {{ $estado === 'ahorro' ? 'text-green-600' : 'text-yellow-600' }}">
                    S/ {{ number_format($retorno, 2) }}
                </p>
            </div>
        </div>

        {{-- Estado de inversión --}}
        <div class="bg-white shadow rounded-2xl p-6 mb-6">
            @if ($estado === 'recuperacion')
                <p class="text-gray-700 text-sm">💡 Aún en recuperación: faltan
                    <span class="font-bold">S/ {{ number_format($faltante, 2) }}</span> para cubrir la inversión inicial.
                </p>
            @else
                <p class="text-green-600 text-sm">✅ Inversión recuperada.</p>
                <p class="text-gray-700 text-sm">Ahorro neto:
                    <span class="font-bold text-green-700">S/ {{ number_format($ahorro, 2) }}</span>
                </p>
            @endif
        </div>

        {{-- Resumen por Sector --}}
        <h2 class="text-lg font-semibold text-gray-700 mt-8 mb-3">🏷️ Resumen por Sector</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($sectoresResumen as $s)
                <a href="{{ route('historial.sector_detalle', $s['id']) }}" class="bg-white shadow rounded-2xl p-4 hover:shadow-lg transition block">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-600">{{ $s['nombre'] }}</span>
                        <span class="text-xs text-gray-400">{{ $s['cantidad'] }} detecciones</span>
                    </div>
                    <p class="text-gray-700 text-sm mb-1">🔍 Enfermedad más reciente: <span class="font-bold">{{ $s['enfermedad'] }}</span></p>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-2 text-xs">
                        Tiempo promedio: <span class="font-bold">{{ number_format($s['tiempo_promedio'], 2) }}s</span>
                    </div>
                </a>
            @empty
                <p class="text-gray-500">No hay sectores con detecciones aún.</p>
            @endforelse
        </div>

    </div>
@endsection
