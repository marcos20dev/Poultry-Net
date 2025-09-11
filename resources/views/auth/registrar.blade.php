@extends('layouts.auth')

@section('title', 'Registro - Poultry Net')

@section('content')
    <div class="card shadow-sm border-0" style="max-width: 450px; margin: 0 auto;">
        <div class="card-body p-4 p-md-5">

            {{-- Logo y título --}}
            <div class="text-center mb-4">
                <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 70px; height: 70px;">
                    <span class="text-white fw-bold fs-4">PN</span>
                </div>
                <h4 class="fw-bold text-success mb-1">Crear Cuenta</h4>
                <p class="text-muted">Únete a Poultry Net</p>
            </div>

            {{-- Formulario --}}
            <form method="POST" action="#" class="text-start" id="registerForm">
                @csrf

                {{-- Nombres --}}
                <div class="mb-3">
                    <label for="nombres" class="form-label small fw-bold">Nombres</label>
                    <input type="text" id="nombres" name="nombres" class="form-control form-control-sm" placeholder="Tus nombres" required
                           minlength="2" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios">
                    <div class="invalid-feedback small" id="nombresError"></div>
                </div>

                {{-- Apellidos --}}
                <div class="mb-3">
                    <label for="apellidos" class="form-label small fw-bold">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" class="form-control form-control-sm" placeholder="Tus apellidos" required
                           minlength="2" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios">
                    <div class="invalid-feedback small" id="apellidosError"></div>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label small fw-bold">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="correo@ejemplo.com" required>
                    <div class="invalid-feedback small" id="emailError"></div>
                </div>

                {{-- Contraseña --}}
                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold">Contraseña</label>
                    <div class="input-group input-group-sm">
                        <input type="password" id="password" name="password" class="form-control" required minlength="6">
                        <button type="button" class="btn btn-outline-secondary toggle-password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    <div class="progress mt-2" style="height: 4px;">
                        <div id="passwordStrength" class="progress-bar" role="progressbar"></div>
                    </div>

                    <div class="form-text small mt-2">
                        <div id="lengthCheck" class="text-muted"><i class="bi bi-x-circle me-1"></i>Mínimo 6 caracteres</div>
                        <div id="letterCheck" class="text-muted"><i class="bi bi-x-circle me-1"></i>Al menos una letra</div>
                    </div>

                    <div class="invalid-feedback small" id="passwordError"></div>
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label small fw-bold">Confirmar Contraseña</label>
                    <div class="input-group input-group-sm">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="form-text small" id="passwordMatchText"></div>
                    <div class="invalid-feedback small" id="passwordConfirmationError"></div>
                </div>

                {{-- Botón --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-sm py-2 fw-bold" id="submitButton" disabled>Registrarse</button>
                </div>
            </form>

            {{-- Link a login --}}
            <div class="text-center mt-4">
                <p class="small mb-0">
                    ¿Ya tienes cuenta? <a href="{{ url('/login') }}" class="text-success text-decoration-none">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>

    {{-- Incluir Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
            border: none;
        }
        .form-control, .form-control:focus {
            border-color: #dee2e6;
            box-shadow: none;
            border-radius: 6px;
            padding: 0.6rem 0.75rem;
            font-size: 0.9rem;
        }
        .form-control-sm {
            padding: 0.5rem 0.75rem;
        }
        .input-group-sm > .form-control {
            border-radius: 6px 0 0 6px;
        }
        .toggle-password {
            border-radius: 0 6px 6px 0;
            border-left: none;
        }
        .btn-success {
            background-color: #198754;
            border: none;
            border-radius: 6px;
            padding: 0.6rem;
        }
        .btn-success:hover {
            background-color: #0f684d;
        }
        .progress {
            background-color: #e9ecef;
            border-radius: 3px;
        }
        .invalid-feedback {
            display: block;
        }
    </style>

    {{-- Script para validación avanzada --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos del DOM
            const form = document.getElementById('registerForm');
            const nombresInput = document.getElementById('nombres');
            const apellidosInput = document.getElementById('apellidos');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordStrength = document.getElementById('passwordStrength');
            const submitButton = document.getElementById('submitButton');

            // Elementos de verificación
            const lengthCheck = document.getElementById('lengthCheck');
            const letterCheck = document.getElementById('letterCheck');
            const passwordMatchText = document.getElementById('passwordMatchText');

            // Toggle para mostrar/ocultar contraseña
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            });

            // Validación de nombres
            nombresInput.addEventListener('input', function() {
                if (this.validity.valid) {
                    this.classList.remove('is-invalid');
                    document.getElementById('nombresError').textContent = '';
                } else {
                    this.classList.add('is-invalid');
                    document.getElementById('nombresError').textContent = 'Solo se permiten letras y espacios (mín. 2 caracteres)';
                }
                validateForm();
            });

            // Validación de apellidos
            apellidosInput.addEventListener('input', function() {
                if (this.validity.valid) {
                    this.classList.remove('is-invalid');
                    document.getElementById('apellidosError').textContent = '';
                } else {
                    this.classList.add('is-invalid');
                    document.getElementById('apellidosError').textContent = 'Solo se permiten letras y espacios (mín. 2 caracteres)';
                }
                validateForm();
            });

            // Validación del email
            emailInput.addEventListener('input', function() {
                if (this.validity.valid) {
                    this.classList.remove('is-invalid');
                    document.getElementById('emailError').textContent = '';
                } else {
                    this.classList.add('is-invalid');
                    document.getElementById('emailError').textContent = 'Por favor, introduce un email válido';
                }
                validateForm();
            });

            // Validación de la contraseña
            passwordInput.addEventListener('input', function() {
                validatePassword();
                validateForm();
            });

            // Validación de confirmación de contraseña
            passwordConfirmationInput.addEventListener('input', function() {
                validatePasswordConfirmation();
                validateForm();
            });

            // Función para validar la contraseña
            function validatePassword() {
                const val = passwordInput.value;
                let strength = 0;
                let errors = [];

                // Verificar longitud
                if (val.length >= 6) {
                    strength += 50;
                    lengthCheck.innerHTML = '<i class="bi bi-check-circle text-success me-1"></i>Mínimo 6 caracteres';
                } else {
                    lengthCheck.innerHTML = '<i class="bi bi-x-circle text-danger me-1"></i>Mínimo 6 caracteres';
                    errors.push('La contraseña debe tener al menos 6 caracteres');
                }

                // Verificar letras
                if (/[A-Za-z]/.test(val)) {
                    strength += 50;
                    letterCheck.innerHTML = '<i class="bi bi-check-circle text-success me-1"></i>Al menos una letra';
                } else {
                    letterCheck.innerHTML = '<i class="bi bi-x-circle text-danger me-1"></i>Al menos una letra';
                    errors.push('La contraseña debe contener al menos una letra');
                }

                // Actualizar barra de fortaleza
                passwordStrength.style.width = strength + '%';

                if (strength <= 50) {
                    passwordStrength.className = 'progress-bar bg-danger';
                } else if (strength < 100) {
                    passwordStrength.className = 'progress-bar bg-warning';
                } else {
                    passwordStrength.className = 'progress-bar bg-success';
                }

                // Mostrar errores
                if (errors.length > 0) {
                    passwordInput.classList.add('is-invalid');
                    document.getElementById('passwordError').textContent = errors[0];
                } else {
                    passwordInput.classList.remove('is-invalid');
                    document.getElementById('passwordError').textContent = '';
                }

                // Validar confirmación cuando cambia la contraseña principal
                validatePasswordConfirmation();
            }

            // Función para validar la confirmación de contraseña
            function validatePasswordConfirmation() {
                const password = passwordInput.value;
                const confirmation = passwordConfirmationInput.value;

                if (confirmation === '') {
                    passwordMatchText.textContent = '';
                    passwordConfirmationInput.classList.remove('is-invalid');
                    document.getElementById('passwordConfirmationError').textContent = '';
                    return;
                }

                if (password === confirmation) {
                    passwordMatchText.innerHTML = '<i class="bi bi-check-circle text-success me-1"></i>Las contraseñas coinciden';
                    passwordConfirmationInput.classList.remove('is-invalid');
                    document.getElementById('passwordConfirmationError').textContent = '';
                } else {
                    passwordMatchText.innerHTML = '<i class="bi bi-x-circle text-danger me-1"></i>Las contraseñas no coinciden';
                    passwordConfirmationInput.classList.add('is-invalid');
                    document.getElementById('passwordConfirmationError').textContent = 'Las contraseñas no coinciden';
                }
            }

            // Función para validar todo el formulario
            function validateForm() {
                const isNombresValid = nombresInput.validity.valid;
                const isApellidosValid = apellidosInput.validity.valid;
                const isEmailValid = emailInput.validity.valid;
                const isPasswordValid = passwordInput.validity.valid &&
                    passwordInput.value.length >= 6 &&
                    /[A-Za-z]/.test(passwordInput.value);
                const isPasswordConfirmationValid = passwordConfirmationInput.value === passwordInput.value;

                if (isNombresValid && isApellidosValid && isEmailValid && isPasswordValid && isPasswordConfirmationValid) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            }

            // Validar formulario al enviar
            form.addEventListener('submit', function(event) {
                validateForm();
                if (submitButton.disabled) {
                    event.preventDefault();
                    event.stopPropagation();

                    // Forzar la visualización de todos los errores
                    if (!nombresInput.validity.valid) {
                        nombresInput.classList.add('is-invalid');
                        document.getElementById('nombresError').textContent = 'Solo se permiten letras y espacios (mín. 2 caracteres)';
                    }

                    if (!apellidosInput.validity.valid) {
                        apellidosInput.classList.add('is-invalid');
                        document.getElementById('apellidosError').textContent = 'Solo se permiten letras y espacios (mín. 2 caracteres)';
                    }

                    if (!emailInput.validity.valid) {
                        emailInput.classList.add('is-invalid');
                        document.getElementById('emailError').textContent = 'Por favor, introduce un email válido';
                    }

                    validatePassword();
                    validatePasswordConfirmation();
                }
            });

            // Inicializar validación
            validateForm();
        });
    </script>
@endsection
