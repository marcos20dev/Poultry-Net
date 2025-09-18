@extends('layouts.app')

@section('title', 'Gestionar Costos')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Gestión de Costos</h1>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($costo)
            <!-- Formulario para editar costo existente -->
            <form action="{{ route('costos.update', $costo->id) }}" method="POST" class="bg-white p-4 rounded shadow space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="gasto_deteccion" class="block font-medium mb-1">Gasto de Detección (S/)</label>
                    <input type="number" step="0.01" name="gasto_deteccion" id="gasto_deteccion"
                           value="{{ old('gasto_deteccion', $costo->gasto_deteccion) }}"
                           class="w-full border border-gray-300 p-2 rounded" required>
                </div>

                <div>
                    <label for="capital_inicial" class="block font-medium mb-1">Capital Inicial (S/)</label>
                    <input type="number" step="0.01" name="capital_inicial" id="capital_inicial"
                           value="{{ old('capital_inicial', $costo->capital_inicial) }}"
                           class="w-full border border-gray-300 p-2 rounded" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Actualizar Costos
                </button>
            </form>
        @else
            <!-- Formulario para registrar por primera vez -->
            <form action="{{ route('costos.store') }}" method="POST" class="bg-white p-4 rounded shadow space-y-4">
                @csrf

                <div>
                    <label for="gasto_deteccion" class="block font-medium mb-1">Gasto de Detección (S/)</label>
                    <input type="number" step="0.01" name="gasto_deteccion" id="gasto_deteccion"
                           class="w-full border border-gray-300 p-2 rounded" required>
                </div>

                <div>
                    <label for="capital_inicial" class="block font-medium mb-1">Capital Inicial (S/)</label>
                    <input type="number" step="0.01" name="capital_inicial" id="capital_inicial"
                           class="w-full border border-gray-300 p-2 rounded" required>
                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Guardar Costos
                </button>
            </form>
        @endif
    </div>
@endsection
