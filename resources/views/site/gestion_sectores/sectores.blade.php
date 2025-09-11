@extends('layouts.app')

@section('title', 'Gestión de Sectores')

@section('content')
    <div class="min-h-screen p-4 sm:p-6"
         x-data="{
            openCreate: false,
            openEdit: false,
            editSector: {},
            showToast: false,
            toastMessage: '',
            deleteConfirm: false,
            sectorToDelete: null
         }"
         x-init="@if(session('success')) showToast = true; toastMessage='{{ session('success') }}'; setTimeout(() => showToast = false, 3000) @endif">

        {{-- Notificación Toast --}}
        <div x-show="showToast" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="fixed top-6 right-6 z-50 px-6 py-4 rounded-xl bg-green-500 text-white shadow-xl flex items-center space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <p x-text="toastMessage" class="font-medium"></p>
        </div>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Sectores</h1>
                <p class="text-gray-600 mt-1">Administra, crea y edita los sectores de la granja</p>
            </div>
            <button @click="openCreate = true"
                    class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:from-green-600 hover:to-green-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Sector
            </button>
        </div>



        {{-- Barra de búsqueda y filtros --}}
        <div class="mb-8 bg-white p-4 rounded-2xl shadow-md border border-gray-100">
            <form method="GET" action="{{ route('sectores.index') }}"
                  class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- Input búsqueda --}}
                <div class="relative md:col-span-2">
                    <input type="text" name="q" placeholder="Buscar por nombre o descripción..."
                           value="{{ request('q') }}"
                           class="w-full px-5 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition pl-12">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                </div>

                {{-- Filtro temperatura --}}
                <select name="temp"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Temperatura</option>
                    <option value="low" {{ request('temp') == 'low' ? 'selected' : '' }}>Baja (&lt; 18°C)</option>
                    <option value="normal" {{ request('temp') == 'normal' ? 'selected' : '' }}>Normal (18°C - 25°C)</option>
                    <option value="high" {{ request('temp') == 'high' ? 'selected' : '' }}>Alta (&gt; 25°C)</option>
                </select>

                {{-- Filtro orden --}}
                <select name="sort"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Ordenar por</option>
                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Más recientes</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Más antiguos</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre</option>
                </select>

                {{-- Botones --}}
                <div class="md:col-span-4 flex flex-col md:flex-row justify-end gap-3">
                    <button type="submit"
                            class="w-full md:w-auto px-6 py-3 bg-green-600 text-white font-medium rounded-xl shadow hover:bg-green-700 transition">
                        Buscar
                    </button>

                    <a href="{{ route('sectores.index') }}"
                       class="w-full md:w-auto px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl shadow hover:bg-gray-300 transition text-center">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- Cards de Sectores --}}
        {{-- Cards de Sectores --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($sectores as $sector)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">

                    {{-- Link clickeable al detalle, solo cubre la parte superior --}}
                    <a href="{{ route('sectores.lote_detalle', $sector) }}" class="block p-5 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $sector->nombre }}</h2>
                            <div class="flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $sector->temperatura > 25 ? 'bg-red-100 text-red-800' :
                           ($sector->temperatura < 18 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ $sector->temperatura }}°C
                            </div>
                        </div>
                        <p class="text-gray-600 mt-3 text-sm line-clamp-2">{{ $sector->descripcion }}</p>
                    </a>

                    {{-- Botones Editar y Eliminar --}}
                    <div class="p-4 bg-gray-50 flex justify-end gap-2">
                        <button @click="openEdit = true; editSector = {{ $sector->toJson() }}"
                                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </button>
                        <button @click="deleteConfirm = true; sectorToDelete = {{ $sector->id }}"
                                class="px-4 py-2 bg-white border border-gray-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-12 px-4 text-center">
                    <div class="bg-gray-100 p-6 rounded-2xl mb-5">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">No hay sectores registrados</h3>
                    <p class="text-gray-500 mb-4">Comienza agregando tu primer sector a la granja</p>
                    <button @click="openCreate = true"
                            class="px-5 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                        Crear primer sector
                    </button>
                </div>
            @endforelse
        </div>

        {{-- Modal Crear Sector --}}
        <div x-show="openCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-300"
                 x-show="openCreate"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="openCreate = false">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Crear Nuevo Sector</h2>
                </div>

                <form x-data="{ nombreInput: '' }" action="{{ route('sectores.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    <!-- Nombre del sector -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del sector</label>
                        <input type="text" name="nombre" x-model="nombreInput" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                               placeholder="Ej: Invernadero principal">

                        <!-- Botones sugeridos -->
                        <div class="mt-2 flex flex-wrap gap-2">
                            <button type="button" @click="nombreInput = 'Sector A'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-green-200 transition">
                                Sector A
                            </button>
                            <button type="button" @click="nombreInput = 'Sector B'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-green-200 transition">
                                Sector B
                            </button>
                            <button type="button" @click="nombreInput = 'Sector C'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-green-200 transition">
                                Sector C
                            </button>
                            <button type="button" @click="nombreInput = 'Sector D'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-green-200 transition">
                                Sector D
                            </button>
                            <button type="button" @click="nombreInput = 'Sector E'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-green-200 transition">
                                Sector E
                            </button>
                        </div>
                    </div>

                    <!-- Temperatura -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura (°C)</label>
                        <input type="number" name="temperatura" step="0.1" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                               placeholder="Ej: 22.5">
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="descripcion" rows="3" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                  placeholder="Describe las características de este sector"></textarea>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="openCreate = false"
                                class="px-5 py-2.5 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            Crear sector
                        </button>
                    </div>
                </form>


            </div>
        </div>

        {{-- Modal Editar Sector --}}
        <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-300"
                 x-show="openEdit"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="openEdit = false">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Editar Sector</h2>
                </div>
                <form :action="`{{ route('sectores.update', ['sector' => 'ID_SECTOR']) }}`.replace('ID_SECTOR', editSector.id)"
                      method="POST" class="p-6 space-y-5" x-data="{ editNombre: '' }"
                      x-init="editNombre = editSector.nombre">
                    @csrf
                    @method('PUT')

                    <!-- Nombre del sector -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del sector</label>
                        <input type="text" name="nombre" x-model="editSector.nombre" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Ej: Invernadero principal">

                        <!-- Botones sugeridos -->
                        <div class="mt-2 flex flex-wrap gap-2">
                            <button type="button" @click="editSector.nombre = 'Sector A'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-blue-200 transition">
                                Sector A
                            </button>
                            <button type="button" @click="editSector.nombre = 'Sector B'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-blue-200 transition">
                                Sector B
                            </button>
                            <button type="button" @click="editSector.nombre = 'Sector C'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-blue-200 transition">
                                Sector C
                            </button>
                            <button type="button" @click="editSector.nombre = 'Sector D'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-blue-200 transition">
                                Sector D
                            </button>
                            <button type="button" @click="editSector.nombre = 'Sector E'"
                                    class="px-3 py-1 bg-gray-200 rounded-full text-sm hover:bg-blue-200 transition">
                                Sector E
                            </button>
                        </div>
                    </div>

                    <!-- Temperatura -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura (°C)</label>
                        <input type="number" name="temperatura" step="0.1" x-model="editSector.temperatura" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Ej: 22.5">
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="descripcion" rows="3" x-model="editSector.descripcion" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                  placeholder="Describe las características de este sector"></textarea>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="openEdit = false"
                                class="px-5 py-2.5 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal de Confirmación de Eliminación --}}
        <div x-show="deleteConfirm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-300"
                 x-show="deleteConfirm"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="deleteConfirm = false">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Confirmar eliminación</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-6">¿Estás seguro de que deseas eliminar este sector? Esta acción no se puede deshacer.</p>
                    <div class="flex justify-end gap-3">
                        <button @click="deleteConfirm = false"
                                class="px-5 py-2.5 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <form :action="`{{ route('sectores.destroy', ['sector' => 'ID_SECTOR']) }}`.replace('ID_SECTOR', sectorToDelete)" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-5 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        [x-cloak] { display: none !important; }
    </style>
@endsection
