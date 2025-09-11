@extends('layouts.app')

@section('title', 'Bienvenido - Poultry Net')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body text-center p-5">

                        {{-- Logo --}}
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-4"
                             style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold fs-3">PN</span>
                        </div>

                        {{-- Mensaje de bienvenida --}}
                        <h3 class="fw-bold text-success mb-3">¡Bienvenido a Poultry Net!</h3>
                        <p class="text-muted fs-6 mb-4">
                            Has iniciado sesión correctamente.
                            <br>Disfruta de todas las funcionalidades de tu panel.
                        </p>
                        <p>Bienvenido, {{ Auth::user()->name }} (ID: {{ Auth::id() }})</p>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ url('/dashboard') }}" class="btn btn-success px-4 py-2">
                                Ir al Dashboard
                            </a>

                            <form method="POST" action="">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger px-4 py-2">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
