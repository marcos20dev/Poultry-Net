<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi App Laravel')</title>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/recomendaciones.js') }}"></script>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

{{-- HEADER --}}
@include('partials.header-app')

{{-- CONTENIDO PRINCIPAL --}}
<main class="flex-grow container mx-auto p-4">
    @yield('content')
</main>

{{-- FOOTER --}}
@include('partials.footer')

</body>
</html>
