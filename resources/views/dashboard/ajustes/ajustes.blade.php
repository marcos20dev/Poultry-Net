@extends('layouts.app')

@section('title', 'Ajustes del Sistema')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Ajustes del Sistema</h1>
            <p class="text-gray-600">Visualiza información y administra los costos del sistema</p>
        </div>

        {{-- Sección de Datos Simulados --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Resumen del Sistema</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Total de usuarios registrados: 45</li>
                <li>Total de sectores: 12</li>
                <li>Total de lotes activos: 30</li>
                <li>Detecciones recientes: 7</li>
            </ul>
        </div>

        {{-- Botón para gestionar costos --}}
        <div class="flex justify-start">
            <a href="{{ route('costos.form') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Gestionar Costos
            </a>
        </div>
    </div>
@endsection
