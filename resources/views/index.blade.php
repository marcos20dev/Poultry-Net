@extends('layouts.invitado')

@section('title', 'PoultryNet - Inicio')

@section('content')
    {{-- Hero principal --}}
    <div class="text-center py-5 bg-light rounded shadow-sm">
        <h1 class="display-4 fw-bold">🐔 PoultryNet</h1>
        <p class="lead">Sistema inteligente para la detección temprana de enfermedades en pollos.</p>
        <a href="{{ url('/login') }}" class="btn btn-primary btn-lg mt-3">Comenzar</a>
    </div>

    {{-- Sección de características --}}
    <div class="row mt-5 text-center">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">📷 Análisis por imágenes</h5>
                    <p class="card-text">Sube fotos de tus aves y detecta signos de posibles enfermedades.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">⚡ Resultados rápidos</h5>
                    <p class="card-text">Obtén diagnósticos preliminares en segundos gracias a IA optimizada.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">📊 Reportes claros</h5>
                    <p class="card-text">Visualiza estadísticas y recomendaciones para mantener tus aves saludables.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA final --}}
    <div class="text-center mt-5">
        <h2 class="fw-bold">Empieza a cuidar tu granja hoy mismo 🐥</h2>
        <a href="{{ url('/register') }}" class="btn btn-success btn-lg mt-3">Crear cuenta gratis</a>
    </div>
@endsection
