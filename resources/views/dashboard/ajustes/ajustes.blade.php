@extends('layouts.app')

@section('title', 'Ajustes de Usuario')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Perfil de Usuario</h1>
            <p class="text-gray-600">Gestiona tu información personal y configuraciones</p>
        </div>

        {{-- Tabs con Alpine.js --}}
        <div x-data="{ activeTab: 'personal' }" class="space-y-6">
            <div class="h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground grid w-full grid-cols-2">
                <button
                    @click="activeTab = 'personal'"
                    :class="activeTab === 'personal' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:bg-gray-100'"
                    class="justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium flex items-center gap-2"
                >
                    Información Personal
                </button>
                <button
                    @click="activeTab = 'configuracion'"
                    :class="activeTab === 'configuracion' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:bg-gray-100'"
                    class="justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium flex items-center gap-2"
                >
                    Configuración
                </button>
            </div>

            {{-- Contenido de Tabs --}}
            <div class="mt-2 space-y-6">

                {{-- Información Personal --}}
                <div x-show="activeTab === 'personal'" x-cloak class="space-y-6">
                    <!-- Contenido de información personal (igual que antes) -->
                </div>

                {{-- Configuración --}}
                <div x-show="activeTab === 'configuracion'" x-cloak class="space-y-6">
                    {{-- Sectores --}}
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-row items-center justify-between p-6 space-y-1.5">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight flex items-center gap-2">
                                Sectores
                            </h3>
                        </div>

                        <div class="p-6 pt-0 space-y-6">
                            {{-- Formulario Crear Sector --}}
                            <div class="p-4 border rounded-lg bg-gray-50">
                                <h4 class="text-lg font-semibold mb-4">Crear Nuevo Sector</h4>
                                <form action="{{ route('sectores.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nombre del Sector</label>
                                        <input type="text" name="nombre" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Temperatura</label>
                                        <input type="number" name="temperatura" step="0.1" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <textarea name="descripcion" rows="3" required
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"></textarea>
                                    </div>
                                    <div>
                                        <button type="submit"
                                                class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-md">
                                            Crear Sector
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Lista de Sectores --}}
                            <div class="p-4 border rounded-lg bg-gray-50">
                                <h4 class="text-lg font-semibold mb-4">Sectores Existentes</h4>
                                <div class="space-y-2">
                                    @foreach($sectores as $sector)
                                        <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                                            <div>
                                                <p class="font-medium">{{ $sector->nombre }}</p>
                                                <p class="text-sm text-gray-500">Temp: {{ $sector->temperatura }}°C</p>
                                            </div>
                                            <form action="{{ route('sectores.destroy', $sector->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-800 font-semibold">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                    @if($sectores->isEmpty())
                                        <p class="text-gray-500">No hay sectores registrados aún.</p>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
