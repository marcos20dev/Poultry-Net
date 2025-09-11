@extends('layouts.app')

@section('title', 'Gestión de Costos')

@section('content')
    <div class="w-full min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">

        {{-- Encabezado --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                💰 Gestión General de Costos
            </h1>
            <p class="text-sm text-gray-500 mt-2 md:mt-0">Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        @php
            // Datos estáticos
            $inversion = 1300;
            $costo_det = 5;
            $detecciones = 20;

            // Cálculos
            $retorno = $costo_det * $detecciones;
            $estado = $retorno >= $inversion ? 'ahorro' : 'recuperacion';
            $ahorro = $estado === 'ahorro' ? $retorno - $inversion : 0;
            $faltante = $estado === 'recuperacion' ? $inversion - $retorno : 0;
            $porcentaje = min(100, ($retorno / $inversion) * 100);
        @endphp

        {{-- Cards principales --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <p class="text-sm text-gray-500">Inversión Inicial</p>
                <p class="text-2xl font-bold text-gray-800">S/ {{ number_format($inversion, 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <p class="text-sm text-gray-500">Costo por Detección</p>
                <p class="text-2xl font-bold text-gray-800">S/ {{ number_format($costo_det, 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <p class="text-sm text-gray-500">Detecciones Realizadas</p>
                <p class="text-2xl font-bold text-gray-800">{{ $detecciones }}</p>
            </div>
        </div>

        {{-- Progreso --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                📊 Progreso de Retorno
            </h2>
            <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden">
                <div class="h-5 rounded-full transition-all duration-700
                {{ $estado === 'ahorro' ? 'bg-green-500' : 'bg-yellow-500' }}"
                     style="width: {{ $porcentaje }}%">
                </div>
            </div>
            <p class="text-sm text-gray-600 mt-2">Progreso: <span class="font-bold">{{ number_format($porcentaje, 1) }}%</span></p>
        </div>

        {{-- Estado Detallado --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📌 Estado Actual</h3>

                @if ($estado === 'recuperacion')
                    <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-4">
                        <p class="text-gray-700 text-lg">💡 Retorno acumulado:
                            <span class="font-bold">S/ {{ number_format($retorno, 2) }}</span>
                        </p>
                        <p class="text-sm text-gray-600 mt-2">Faltan
                            <span class="font-bold">S/ {{ number_format($faltante, 2) }}</span>
                            para recuperar la inversión inicial.
                        </p>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-300 rounded-xl p-4">
                        <p class="text-gray-700 text-lg">✅ Inversión recuperada</p>
                        <p class="text-green-700 text-lg mt-2">Ahorro neto:
                            <span class="font-bold">S/ {{ number_format($ahorro, 2) }}</span>
                        </p>
                    </div>
                @endif
            </div>

            {{-- Resumen Financiero --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📈 Resumen Financiero</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex justify-between">
                        <span>Inversión inicial</span>
                        <span class="font-bold">S/ {{ number_format($inversion, 2) }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Retorno acumulado</span>
                        <span class="font-bold">S/ {{ number_format($retorno, 2) }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Ahorro neto</span>
                        <span class="font-bold {{ $estado === 'ahorro' ? 'text-green-600' : 'text-gray-400' }}">
                        S/ {{ number_format($ahorro, 2) }}
                    </span>
                    </li>
                    <li class="flex justify-between">
                        <span>Faltante para ROI</span>
                        <span class="font-bold {{ $estado === 'recuperacion' ? 'text-yellow-600' : 'text-gray-400' }}">
                        S/ {{ number_format($faltante, 2) }}
                    </span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
@endsection
