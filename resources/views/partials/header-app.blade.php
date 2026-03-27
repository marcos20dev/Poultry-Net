<nav class="bg-white/90 backdrop-blur-md border-b border-gray-100 px-6 py-3 shadow-sm" x-data="{ drawerOpen: false }">
    <div class="flex items-center justify-between">

        <!-- Logo + Menú alineados a la izquierda -->
        <div class="flex items-center space-x-8">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg group-hover:scale-105 transition-transform duration-300">
                    PN
                </div>
                <span class="self-center text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-700 bg-clip-text text-transparent">Poultry Net</span>
            </a>

            <!-- Menú PC -->
            <div class="hidden md:flex items-center space-x-1">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-4 py-2 rounded-xl font-medium transition-all duration-300 group
                   {{ request()->routeIs('dashboard') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-700 hover:text-emerald-700 hover:bg-emerald-50' }}">
                    <i class="fas fa-home mr-2 {{ request()->routeIs('dashboard') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }}"></i>
                    <span class="relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-emerald-600 after:transition-all after:duration-300
                    {{ request()->routeIs('dashboard') ? 'after:w-full' : 'after:w-0 group-hover:after:w-full' }}">
                        Dashboard
                    </span>
                </a>

                {{-- Gestión de Sectores --}}
                <a href="{{ route('sectores.index') }}"
                   class="flex items-center px-4 py-2 rounded-xl font-medium transition-all duration-300 group
                   {{ request()->routeIs('sectores.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50' }}">
                    <i class="fas fa-dove mr-2 {{ request()->routeIs('sectores.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }}"></i>
                    <span class="relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-emerald-600 after:transition-all after:duration-300
                    {{ request()->routeIs('sectores.*') ? 'after:w-full' : 'after:w-0 group-hover:after:w-full' }}">
                        Gestión de Sectores
                    </span>
                </a>

                {{-- Gestión de Lotes --}}
                <a href="{{ route('lotes.index') }}"
                   class="flex items-center px-4 py-2 rounded-xl font-medium transition-all duration-300 group
                   {{ request()->routeIs('lotes.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50' }}">
                    <i class="fas fa-layer-group mr-2 {{ request()->routeIs('lotes.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }}"></i>
                    <span class="relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-emerald-600 after:transition-all after:duration-300
                    {{ request()->routeIs('lotes.*') ? 'after:w-full' : 'after:w-0 group-hover:after:w-full' }}">
                        Gestión de Lotes
                    </span>
                </a>

                {{-- Historial --}}
                <a href="{{ route('historial.index') }}"
                   class="flex items-center px-4 py-2 rounded-xl font-medium transition-all duration-300 group
                   {{ request()->routeIs('historial.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50' }}">
                    <i class="fas fa-history mr-2 {{ request()->routeIs('historial.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }}"></i>
                    <span class="relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-emerald-600 after:transition-all after:duration-300
                    {{ request()->routeIs('historial.*') ? 'after:w-full' : 'after:w-0 group-hover:after:w-full' }}">
                        Historial
                    </span>
                </a>

                {{-- Costos --}}
                <a href="{{ route('costos.index') }}"
                   class="flex items-center px-4 py-2 rounded-xl font-medium transition-all duration-300 group
                   {{ request()->routeIs('costos.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50' }}">
                    <i class="fas fa-dollar-sign mr-2 {{ request()->routeIs('costos.*') ? 'text-emerald-600' : 'text-gray-500 group-hover:text-emerald-600' }}"></i>
                    <span class="relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:bg-emerald-600 after:transition-all after:duration-300
                    {{ request()->routeIs('costos.*') ? 'after:w-full' : 'after:w-0 group-hover:after:w-full' }}">
                        Costos
                    </span>
                </a>
            </div>
        </div>

        <!-- Botón hamburguesa: solo en móvil -->
        <div class="md:hidden ml-auto">
            <button @click="drawerOpen = !drawerOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-800 transition">
                <svg x-show="!drawerOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <svg x-show="drawerOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Usuario a la derecha -->
        @auth
            @php
                $firstInitial = strtoupper(substr(Auth::user()->nombres ?? '', 0, 1));
                $lastInitial  = strtoupper(substr(Auth::user()->apellidos ?? '', 0, 1));
                $initials = $firstInitial . $lastInitial;
            @endphp

            <div class="relative" x-data="{ open: false }">
                <div @click="open = !open"
                     class="hidden md:flex items-center justify-center w-10 h-10 rounded-full bg-green-600 text-white font-medium shadow-lg hover:shadow-emerald-200 hover:scale-105 transition-all duration-300 cursor-pointer">
                    {{ $initials ?: 'U' }}
                </div>

                <div class="hidden md:block">
                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50 transition-all duration-300"
                         style="display: none;">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50 transition-colors">Perfil</a>
                        <a href="{{route('vista.ajustes')}}" class="block px-4 py-2 text-gray-700 hover:bg-emerald-50 transition-colors">Ajustes</a>
                        <form method="POST" action="{{ route('cerrar.sesion') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-emerald-50 transition-colors">
                                Cerrar sesión
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        @endauth

    </div>

    <!-- Drawer para móvil -->
    <div x-show="drawerOpen" @click.away="drawerOpen = false"
         class="md:hidden absolute top-full left-0 w-full bg-white shadow-lg z-40 transition-all duration-300">
        <div class="flex flex-col px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-emerald-50">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
            <a href="{{ route('sectores.index') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-emerald-50">
                <i class="fas fa-dove mr-2"></i> Gestión de Sectores
            </a>
            <a href="{{ route('lotes.index') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-emerald-50">
                <i class="fas fa-layer-group mr-2"></i> Gestión de Lotes
            </a>
            <a href="{{ route('historial.index') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-emerald-50">
                <i class="fas fa-history mr-2"></i> Historial
            </a>
            <a href="{{ route('costos.index') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-emerald-50">
                <i class="fas fa-dollar-sign mr-2"></i> Costos
            </a>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
