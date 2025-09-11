<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        {{-- Logo / Marca --}}
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            🐔 PoultryNet
        </a>

        {{-- Botones de login y registro (provisorios) --}}
        <div class="d-flex">
            <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">
                Iniciar Sesión
            </a>
            <a class="btn btn-primary" href="{{ route('vista.registro') }}">
                Registrarse
            </a>
        </div>
    </div>
</nav>
