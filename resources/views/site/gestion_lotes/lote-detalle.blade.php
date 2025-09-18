@extends('layouts.app')

@section('title', 'Lotes de ' . $sector->nombre)

@section('content')
    <div class="min-h-screen bg-gradient-to-br to-indigo-100 p-4 md:p-6">
        @include('partials.header', ['sector' => $sector, 'lotes' => $lotes])

        @if(session('success'))
            <div class="max-w-6xl mx-auto mb-6">
                <div class="p-4 text-sm text-green-800 bg-green-50 rounded-lg flex items-center" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="max-w-6x2 mx-auto bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
                    <i class="fas fa-microscope mr-3 text-blue-600"></i>Registrar Detección Manual
                </h2>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Sector: {{ $sector->nombre }}</span>
            </div>

            <form method="POST" action="{{ route('detecciones.store') }}" enctype="multipart/form-data" id="deteccionForm">
                @csrf
                <input type="hidden" name="sector_id" value="{{ $sector->id }}">

                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Sección de Imagen (Izquierda) -->
                    <div class="w-full lg:w-2/5 bg-gray-50 p-5 rounded-xl border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-image mr-2 text-blue-500"></i> Imagen de la Muestra
                        </h3>

                        <div class="mb-4">
                            <div class="flex items-center justify-center w-full">
                                <label for="imagenInput" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-all duration-200">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click para subir</span> o arrastra una imagen</p>
                                        <p class="text-xs text-gray-500">Formatos: JPG, PNG, WEBP (máx. 10MB)</p>
                                    </div>
                                    <input id="imagenInput" name="imagen" type="file" class="hidden" required accept="image/jpeg,image/png,image/webp" />
                                </label>
                            </div>
                        </div>

                        <div id="imagePreview" class="hidden mt-4 flex justify-center">
                            <div class="relative">
                                <img id="preview" class="max-h-64 rounded-lg shadow-md" src="" alt="Vista previa">
                                <button type="button" id="removeImage" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Botón Detectar -->
                        <div class="text-center mt-6">
                            <button type="button" id="btnDetectar" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-800 transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center mx-auto w-full opacity-50" disabled>
                                <i class="fas fa-robot mr-3"></i> Detectar Enfermedad
                            </button>
                        </div>
                    </div>

                    <!-- Sección de Formulario (Derecha) -->
                    <div class="w-full lg:w-3/5">
                        <!-- Resultados de Detección -->
                        <div id="detectionResults" class="hidden bg-blue-50 p-5 rounded-xl border border-blue-200 mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Resultados de la Detección
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Enfermedad -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2">Enfermedad detectada</label>
                                    <div class="relative">
                                        <input type="text" name="enfermedad" id="enfermedadInput" class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required readonly>
                                        <i class="fas fa-disease absolute left-3 top-3.5 text-gray-400"></i>
                                    </div>
                                </div>

                                <!-- Confianza -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-semibold mb-2">Nivel de Confianza (%)</label>
                                    <div class="relative">
                                        <input type="number" step="0.01" name="confianza" id="confianzaInput" class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required readonly>
                                        <i class="fas fa-chart-line absolute left-3 top-3.5 text-gray-400"></i>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                        <div id="confidenceBar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tiempo detección -->
                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Tiempo de detección (segundos)</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="tiempo_deteccion" id="tiempoInput" class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required readonly>
                                    <i class="fas fa-stopwatch absolute left-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Información Adicional -->
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i> Información Adicional
                            </h3>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Observaciones</label>
                                <div class="relative">
                                    <textarea name="observaciones" class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Ingrese observaciones relevantes..."></textarea>
                                    <i class="fas fa-sticky-note absolute left-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Recomendación</label>
                                <div class="relative">
                                    <textarea name="recomendacion" class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Ingrese recomendaciones..."></textarea>
                                    <i class="fas fa-lightbulb absolute left-3 top-3.5 text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6">
                            <a href="{{ url()->previous() }}" class="px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-colors duration-200 text-center">
                                <i class="fas fa-arrow-left mr-2"></i> Volver
                            </a>
                            <button type="submit" id="submitButton" disabled class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl shadow-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i> Guardar Detección
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mb-4"></div>
            <p class="text-gray-700">Analizando imagen...</p>
        </div>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="hidden fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded max-w-md z-50">
        <span class="block sm:inline" id="errorText"></span>
        <button type="button" class="absolute top-0 right-0 p-1" onclick="document.getElementById('errorMessage').classList.add('hidden')">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imagenInput = document.getElementById('imagenInput');
            const imagePreview = document.getElementById('imagePreview');
            const preview = document.getElementById('preview');
            const removeImage = document.getElementById('removeImage');
            const btnDetectar = document.getElementById('btnDetectar');
            const detectionResults = document.getElementById('detectionResults');
            const submitButton = document.getElementById('submitButton');
            const confidenceBar = document.getElementById('confidenceBar');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const errorMessage = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');
            const tiempoInput = document.getElementById('tiempoInput');

            // Preview de imagen
            imagenInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        btnDetectar.disabled = false;
                        btnDetectar.classList.remove('opacity-50');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Eliminar imagen
            removeImage.addEventListener('click', function() {
                imagenInput.value = '';
                imagePreview.classList.add('hidden');
                btnDetectar.disabled = true;
                btnDetectar.classList.add('opacity-50');
                detectionResults.classList.add('hidden');
                submitButton.disabled = true;
                tiempoInput.value = '';
            });

            // Detección con contador de tiempo
            btnDetectar.addEventListener('click', async function() {
                if (!imagenInput.files[0]) {
                    showError('Por favor, seleccione una imagen primero.');
                    return;
                }

                loadingOverlay.classList.remove('hidden');
                const originalText = btnDetectar.innerHTML;
                btnDetectar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Analizando...';
                btnDetectar.disabled = true;

                // Iniciar contador de tiempo
                let tiempo = 0;
                tiempoInput.value = tiempo.toFixed(0);
                const interval = setInterval(() => {
                    tiempo += 1;
                    tiempoInput.value = tiempo;
                }, 1000);

                try {
                    const formData = new FormData();
                    formData.append('image', imagenInput.files[0]);
                    formData.append('_token', '{{ csrf_token() }}');

                    const response = await fetch('{{ route("poultry.process") }}', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    const data = await response.json();

                    if (data.success) {
                        document.getElementById('enfermedadInput').value = data.prediction.predicted_class;
                        document.getElementById('confianzaInput').value = (data.prediction.max_confidence * 100).toFixed(2);
                        confidenceBar.style.width = `${data.prediction.max_confidence * 100}%`;

                        detectionResults.classList.remove('hidden');
                        submitButton.disabled = false;
                        detectionResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        showError(data.error || 'Error en el análisis de la imagen');
                    }
                } catch (error) {
                    showError('Error de conexión: ' + error.message);
                } finally {
                    clearInterval(interval); // detener contador
                    btnDetectar.innerHTML = originalText;
                    btnDetectar.disabled = false;
                    loadingOverlay.classList.add('hidden');
                }
            });

            function showError(message) {
                errorText.textContent = message;
                errorMessage.classList.remove('hidden');
                setTimeout(() => { errorMessage.classList.add('hidden'); }, 5000);
            }
        });
    </script>
@endsection
