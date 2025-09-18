@extends('layouts.app')

@section('title', 'Gestión de Lotes')

@section('content')
    <div class="w-full px-4 py-6">
        {{-- Header optimizado para pantalla completa --}}
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">Gestión de Lotes</h1>
                <p class="text-gray-500 text-sm mt-1">Adminissssss pollos</p>
            </div>
            <div>
                <button @click="openCreateModal = true"
                        class="w-full sm:w-auto px-5 py-3 bg-gradient-to-r from-emerald-600 to-green-500 text-white font-medium rounded-xl shadow-lg hover:shadow-emerald-200 active:scale-95 transition-all duration-300 flex items-center justify-center space-x-2">
                    <i class="fas fa-plus-circle"></i>
                    <span class="hidden sm:inline">Nuevo Lote</span>
                </button>
            </div>
        </div>

        {{-- Modal de confirmación para eliminar --}}
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Confirmar eliminación</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-gray-600 mb-6">¿Estás seguro de que deseas eliminar este lote? Esta acción no se puede deshacer.</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Cancelar
                    </button>
                    <button id="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
        {{-- Modal Editar Lote --}}
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg mx-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Editar Lote</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                            <input type="text" name="raza" id="editRaza" required
                                   class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                                <input type="number" name="cantidad_pollos" id="editCantidad" min="0" required
                                       class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Edad (días)</label>
                                <input type="number" name="edad_dias" id="editEdad" min="0" required
                                       class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Etapa</label>
                            <select name="etapa" id="editEtapa" required
                                    class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                <option value="Inicio">Inicio</option>
                                <option value="Crecimiento">Crecimiento</option>
                                <option value="Finalización">Finalización</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                                <select name="sector_id" id="editSector" required
                                        class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                    @foreach($sectores as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Ingreso</label>
                                <input type="date" name="fecha_ingreso" id="editFecha" required
                                       class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Layout principal: formulario a la izquierda, tarjetas a la derecha --}}
        <div class="flex flex-col xl:flex-row gap-6 w-full">
            {{-- Formulario Crear Lote --}}
            <div class="xl:w-2/5 bg-white p-5 rounded-2xl shadow-md">
                <h2 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-plus-circle text-emerald-600 mr-2"></i>
                    Crear Nuevo Lote
                </h2>
                <form action="{{ route('lotes.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                        <input type="text" name="raza" required
                               class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                            <input type="number" name="cantidad_pollos" required min="0"
                                   class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Edad (días)</label>
                            <input type="number" name="edad_dias" required min="0"
                                   class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Etapa</label>
                        <select name="etapa" required
                                class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">Seleccionar</option>
                            <option value="Inicio">Inicio</option>
                            <option value="Crecimiento">Crecimiento</option>
                            <option value="Finalización">Finalización</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                            <select name="sector_id" required
                                    class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                <option value="">Seleccionar</option>
                                @foreach($sectores as $sector)
                                    <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Ingreso</label>
                            <input type="date" name="fecha_ingreso" required
                                   class="w-full rounded-xl p-3 border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                        <button type="reset"
                                class="order-2 sm:order-1 w-full sm:w-auto px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm">
                            Limpiar
                        </button>
                        <button type="submit"
                                class="order-1 sm:order-2 w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-green-500 text-white font-medium rounded-xl shadow-lg hover:shadow-emerald-200 active:scale-95 transition-all duration-300 text-sm">
                            Crear Lote
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tarjetas de Lotes --}}
            <div class="xl:w-3/5 w-full">
                {{-- Tarjetas de estadísticas --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Lotes Activos</p>
                            <h3 class="text-lg font-bold text-emerald-700">{{ count($lotes) }}</h3>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-layer-group text-emerald-600 text-sm"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Total Pollos</p>
                            <h3 class="text-lg font-bold text-emerald-700">{{ $lotes->sum('cantidad_pollos') }}</h3>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-dove text-emerald-600 text-sm"></i>
                        </div>
                    </div>
                </div>

                {{-- Lista de Lotes en formato tarjeta --}}
                <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6 w-full">
                    <div class="px-4 py-3 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                        <h2 class="text-lg font-semibold text-gray-800">Tus Lotes</h2>
                        <div class="relative w-full sm:w-64">
                            <input type="text" placeholder="Buscar lote..."
                                   class="text-sm pl-9 pr-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                        </div>
                    </div>

                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 max-h-[600px] overflow-y-auto w-full">
                        @forelse($lotes as $lote)
                            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 w-full">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-dove text-emerald-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $lote->raza }}</h3>
                                            <p class="text-xs text-gray-500">{{ $lote->sector->nombre ?? 'Sin sector' }}</p>
                                        </div>
                                    </div>
                                    <span class="bg-emerald-100 text-emerald-700 py-1 px-2 rounded-full text-xs font-medium">
                                        {{ $lote->cantidad_pollos }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div class="flex flex-col items-center justify-center p-2 bg-blue-50 rounded-lg">
                                        <div class="text-xs text-blue-600 mb-1">Edad</div>
                                        <div class="flex items-baseline">
                                            <span class="text-lg font-bold text-blue-700">{{ $lote->edad_dias }}</span>
                                            <span class="text-xs text-blue-500 ml-1">días</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center justify-center p-2 rounded-lg
                                        @php
                                            $etapaColor = match($lote->etapa) {
                                                'Inicio' => 'bg-blue-100',
                                                'Crecimiento' => 'bg-amber-100',
                                                'Finalización' => 'bg-green-100',
                                                default => 'bg-gray-100'
                                            };
                                        @endphp
                                        {{ $etapaColor }}">
                                        <div class="text-xs
                                            @php
                                                $etapaText = match($lote->etapa) {
                                                    'Inicio' => 'text-blue-600',
                                                    'Crecimiento' => 'text-amber-600',
                                                    'Finalización' => 'text-green-600',
                                                    default => 'text-gray-600'
                                                };
                                            @endphp
                                            {{ $etapaText }} mb-1">Etapa</div>
                                        <div class="text-sm font-medium
                                            @php
                                                $etapaText = match($lote->etapa) {
                                                    'Inicio' => 'text-blue-700',
                                                    'Crecimiento' => 'text-amber-700',
                                                    'Finalización' => 'text-green-700',
                                                    default => 'text-gray-700'
                                                };
                                            @endphp
                                            {{ $etapaText }}">{{ $lote->etapa }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center text-xs text-gray-500 mb-4">
                                    <i class="far fa-calendar mr-1"></i>
                                    Ingreso: {{ \Carbon\Carbon::parse($lote->fecha_ingreso)->format('d/m/Y') }}
                                </div>

                                <div class="flex space-x-2 border-t border-gray-100 pt-3">
                                    {{-- Editar --}}
                                    <button onclick="openEditModal({{ $lote->id }}, '{{ $lote->raza }}', {{ $lote->cantidad_pollos }}, {{ $lote->edad_dias }}, '{{ $lote->etapa }}', {{ $lote->sector_id }}, '{{ $lote->fecha_ingreso }}')"
                                            class="flex-1 p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-300 shadow hover:shadow-md flex items-center justify-center">
                                        <i class="fas fa-pen text-xs mr-1"></i>
                                        <span class="text-xs">Editar</span>
                                    </button>

                                    {{-- Eliminar --}}
                                    <button onclick="openDeleteModal('{{ $lote->id }}', '{{ $lote->raza }}')"
                                            class="flex-1 p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-300 shadow hover:shadow-md flex items-center justify-center">
                                        <i class="fas fa-trash text-xs mr-1"></i>
                                        <span class="text-xs">Eliminar</span>
                                    </button>
                                </div>

                            </div>
                        @empty
                            <div class="col-span-3 p-8 text-center w-full">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-3"></i>
                                    <p class="text-sm">No hay lotes registrados</p>
                                    <p class="text-xs mt-1">Crea tu primer lote</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Asegurar que ocupe todo el ancho */
        .w-full {
            width: 100% !important;
        }

        /* Mejoras de usabilidad móvil */
        @media (max-width: 1280px) {
            .xl\:flex-row {
                flex-direction: column;
            }
            .xl\:w-2\/5, .xl\:w-3\/5 {
                width: 100%;
            }
        }

        @media (max-width: 1024px) {
            .xl\:grid-cols-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .xl\:grid-cols-3, .md\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .px-4 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            input, select {
                font-size: 16px !important;
            }
        }

        /* Mejoras de accesibilidad */
        button:focus, input:focus, select:focus {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        /* Scroll personalizado */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Asegurar que todo ocupe el ancho completo */
        body, html {
            width: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <script>
        let currentLoteId = null;

        // 🟢 ABRIR MODAL EDITAR
        function openEditModal(id, raza, cantidad, edad, etapa, sectorId, fecha) {
            currentLoteId = id;
            document.getElementById('editForm').action = "{{ url('lotes') }}/" + id;
            document.getElementById('editRaza').value = raza;
            document.getElementById('editCantidad').value = cantidad;
            document.getElementById('editEdad').value = edad;
            document.getElementById('editEtapa').value = etapa;
            document.getElementById('editSector').value = sectorId;
            document.getElementById('editFecha').value = fecha;

            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // 🔴 CERRAR MODAL EDITAR
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentLoteId = null;
        }

        // 🟠 ELIMINAR (abrir modal confirmación)
        function openDeleteModal(id, name) {
            currentLoteId = id;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // 🔴 CERRAR MODAL ELIMINAR
        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentLoteId = null;
        }

        // ✅ CONFIRMAR ELIMINAR
        document.getElementById('confirmDelete').addEventListener('click', function () {
            if (currentLoteId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ url('lotes') }}/" + currentLoteId;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>

@endsection
