<nav x-data="{ open: false }" class="bg-gradient-to-r from-[#7B2CBF] to-[#9D4EDD] border-b border-purple-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo y nombre -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="bg-white p-1.5 rounded-lg shadow-md group-hover:shadow-lg transition-all duration-200">
                        <img src="{{ asset('images/logo.jpg') }}" class="h-8 w-8 object-contain" alt="{{ config('app.name') }}">
                    </div>
                    <span class="font-bold text-xl text-white tracking-tight hidden sm:inline group-hover:text-purple-100 transition-colors">
                        {{ config('app.name') }}
                    </span>
                </a>
            </div>

            <!-- Menú desktop -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:space-x-1">
                    <a href="{{ route('dashboard') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('productos.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('productos.*') ? 'bg-white/20' : '' }}">
                        Productos
                    </a>
                    <a href="{{ route('inventarios.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('inventarios.*') ? 'bg-white/20' : '' }}">
                        Inventario
                    </a>
                    <a href="{{ route('proveedores.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('proveedores.*') ? 'bg-white/20' : '' }}">
                        Proveedores
                    </a>
                    <a href="{{ route('clientes.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('clientes.*') ? 'bg-white/20' : '' }}">
                        Clientes
                    </a>
                    <a href="{{ route('ventas.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('ventas.*') ? 'bg-white/20' : '' }}">
                        Ventas
                    </a>
                    @if(Route::has('informes.ventas'))
                        <a href="{{ route('informes.ventas') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('informes.*') ? 'bg-white/20' : '' }}">
                            Informes
                        </a>
                    @elseif(Route::has('ventas.stats'))
                        <a href="{{ route('ventas.stats') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium text-white hover:bg-white/10 transition-all duration-200">
                            Informes
                        </a>
                    @endif
                </div>
            @endauth

            <!-- Usuario y menú móvil -->
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition-all duration-200">
                        Iniciar sesión
                    </a>
                @endguest

                @auth
                    <!-- Menú de usuario (desktop) -->
                    <div class="hidden sm:block">
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button @click="userMenuOpen = !userMenuOpen" 
                                    class="flex items-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg transition-all duration-200 group">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-white font-medium text-sm">{{ auth()->user()->name }}</span>
                                </div>
                                <svg class="w-4 h-4 text-white transition-transform duration-200"
                                     :class="{ 'rotate-180': userMenuOpen }"
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="userMenuOpen" 
                                 @click.away="userMenuOpen = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 x-cloak
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Perfil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Botón menú móvil -->
                    <div class="sm:hidden">
                        <button @click="open = !open" 
                                class="p-2 rounded-lg hover:bg-white/10 transition-all duration-200">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Menú móvil -->
    @auth
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="sm:hidden border-t border-white/10 bg-[#7B2CBF]">
            <div class="px-4 pt-4 pb-4 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('productos.index') }}" 
                   class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all {{ request()->routeIs('productos.*') ? 'bg-white/20' : '' }}">
                    Productos
                </a>
                <a href="{{ route('inventarios.index') }}" 
                   class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all {{ request()->routeIs('inventarios.*') ? 'bg-white/20' : '' }}">
                    Inventario
                </a>
                <a href="{{ route('proveedores.index') }}" 
                   class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all {{ request()->routeIs('proveedores.*') ? 'bg-white/20' : '' }}">
                    Proveedores
                </a>
                <a href="{{ route('clientes.index') }}" 
                   class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all {{ request()->routeIs('clientes.*') ? 'bg-white/20' : '' }}">
                    Clientes
                </a>
                <a href="{{ route('ventas.index') }}" 
                   class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all {{ request()->routeIs('ventas.*') ? 'bg-white/20' : '' }}">
                    Ventas
                </a>
                @if(Route::has('informes.ventas'))
                    <a href="{{ route('informes.ventas') }}" 
                       class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all {{ request()->routeIs('informes.*') ? 'bg-white/20' : '' }}">
                        Informes
                    </a>
                @elseif(Route::has('ventas.stats'))
                    <a href="{{ route('ventas.stats') }}" 
                       class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all">
                        Informes
                    </a>
                @endif

                <div class="pt-4 mt-4 border-t border-white/20">
                    <div class="flex items-center gap-3 px-3 py-2 mb-2">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <span class="text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-white font-medium text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-purple-200 text-xs">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" 
                       class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all">
                        Perfil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-3 py-2.5 rounded-lg text-white font-medium hover:bg-white/10 transition-all">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>