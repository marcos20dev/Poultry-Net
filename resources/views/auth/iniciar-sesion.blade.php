@extends('layouts.auth')

@section('title', 'Iniciar Sesión - Poultry Net')

@section('content')
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 bg-white">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-md-5">

                    {{-- Logo y título --}}
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 70px; height: 70px;">
                            <span class="text-white fw-bold fs-4">PN</span>
                        </div>
                        <h4 class="fw-bold text-success mb-1">Bienvenido</h4>
                        <p class="text-muted">Inicia sesión en Poultry Net</p>
                    </div>

                    {{-- Mostrar errores de validación --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Mostrar mensajes de sesión --}}
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" id="loginForm" novalidate>
                        @csrf

                        {{-- Correo electrónico --}}
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold">Correo electrónico</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror"
                                   placeholder="correo@ejemplo.com"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   autofocus>
                            @error('email')
                            <div class="invalid-feedback small d-block">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback small" id="emailError"></div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-4">
                            <label for="password" class="form-label small fw-bold">Contraseña</label>
                            <div class="input-group input-group-sm">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required
                                       minlength="6"
                                       autocomplete="current-password">
                                <button type="button" class="btn btn-outline-secondary toggle-password" aria-label="Mostrar contraseña">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback small" id="passwordError"></div>
                        </div>

                        {{-- Recordar sesión y olvidé contraseña --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-muted" for="remember">Recordar sesión</label>
                            </div>
                            <a href="" class="small text-success text-decoration-none">¿Olvidaste tu contraseña?</a>
                        </div>

                        {{-- Botón --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-sm py-2 fw-bold" id="submitButton">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    {{-- Link a registro --}}
                    <div class="text-center mt-4">
                        <p class="small mb-0">
                            ¿No tienes cuenta?
                            <a href="{{ route('vista.registro') }}" class="text-success text-decoration-none">Regístrate aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    {{-- Estilos --}}
    <style>
        .min-vh-100 {
            min-height: 100vh;
        }
        .card {
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
            transition: all 0.3s ease;
        }
        .btn-success:hover:not(:disabled) {
            background-color: #0f684d;
            transform: translateY(-1px);
        }
        .btn-success:disabled {
            background-color: #6c757d;
            border-color: #6c757d;
            cursor: not-allowed;
        }
        /* Ocultar mensajes de validación por defecto */
        .invalid-feedback {
            display: none;
        }
        /* Mostrar mensajes solo si el input tiene is-invalid */
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>

    {{-- Script validación --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            // Toggle contraseña
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    const icon = this.querySelector('i');
                    const isPassword = input.type === 'password';

                    input.type = isPassword ? 'text' : 'password';
                    icon.classList.toggle('bi-eye', !isPassword);
                    icon.classList.toggle('bi-eye-slash', isPassword);
                    this.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
                });
            });

            // Validar email
            function validateEmail() {
                const email = emailInput.value.trim();
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email) {
                    emailInput.classList.add('is-invalid');
                    emailError.textContent = 'El correo electrónico es requerido';
                    emailError.style.display = 'block';
                    return false;
                }
                if (!regex.test(email)) {
                    emailInput.classList.add('is-invalid');
                    emailError.textContent = 'Por favor ingresa un correo electrónico válido';
                    emailError.style.display = 'block';
                    return false;
                }
                emailInput.classList.remove('is-invalid');
                emailError.textContent = '';
                emailError.style.display = 'none';
                return true;
            }

            // Validar contraseña
            function validatePassword() {
                const pass = passwordInput.value;
                if (!pass) {
                    passwordInput.classList.add('is-invalid');
                    passwordError.textContent = 'La contraseña es requerida';
                    passwordError.style.display = 'block';
                    return false;
                }
                if (pass.length < 6) {
                    passwordInput.classList.add('is-invalid');
                    passwordError.textContent = 'La contraseña debe tener al menos 6 caracteres';
                    passwordError.style.display = 'block';
                    return false;
                }
                passwordInput.classList.remove('is-invalid');
                passwordError.textContent = '';
                passwordError.style.display = 'none';
                return true;
            }

            // Validar todo
            function validateForm() {
                return validateEmail() & validatePassword();
            }

            emailInput.addEventListener('input', debounce(validateEmail, 300));
            passwordInput.addEventListener('input', debounce(validatePassword, 300));

            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    validateEmail();
                    validatePassword();
                }
            });

            function debounce(func, wait) {
                let timeout;
                return function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, arguments), wait);
                };
            }
        });
    </script>
@endsection
