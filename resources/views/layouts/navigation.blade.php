<nav x-data="{ open: false }" class="bg-purple-700 border-b border-purple-600 text-white shadow-lg">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16 items-center">
			<div class="flex items-center">
				<a href="{{ route('dashboard') }}" class="flex items-center gap-3">
					<img src="{{ asset('images/logo.jpg') }}" class="h-9 w-9 drop-shadow-lg" alt="{{ config('app.name') }}">
					<span class="font-extrabold text-xl tracking-wide hidden sm:inline">{{ config('app.name') }}</span>
				</a>

				@auth
					<div class="hidden sm:flex sm:ml-6 sm:space-x-6 text-md">
						<a href="{{ route('dashboard') }}" class="hover:text-purple-200 transition">Dashboard</a>
						<a href="{{ route('productos.index') }}" class="hover:text-purple-200 transition">Productos</a>
						<a href="{{ route('inventarios.index') }}" class="hover:text-purple-200 transition">Inventario</a>
						<a href="{{ route('proveedores.index') }}" class="hover:text-purple-200 transition">Proveedores</a>
						<a href="{{ route('clientes.index') }}" class="hover:text-purple-200 transition">Clientes</a>
						<a href="{{ route('ventas.index') }}" class="hover:text-purple-200 transition">Ventas</a>
						@if(Route::has('informes.ventas'))
							<a href="{{ route('informes.ventas') }}" class="hover:text-purple-200 transition">Informes</a>
						@elseif(Route::has('ventas.stats'))
							<a href="{{ route('ventas.stats') }}" class="hover:text-purple-200 transition">Informes</a>
						@endif
					</div>
				@endauth
			</div>

			<div class="flex items-center space-x-4">
				@guest
					<a href="{{ route('login') }}" class="text-white text-sm">Iniciar sesión</a>
				@endguest

				@auth
					<div class="hidden sm:flex sm:items-center sm:ml-6">
						<div class="relative" x-data="{ userMenuOpen: false }">
							<button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 bg-purple-600 hover:bg-purple-500 px-3 py-2 rounded-lg">
								<span class="text-white font-medium">{{ auth()->user()->name }}</span>
								<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
								</svg>
							</button>

							<div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
								 class="absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-xl py-2 z-40">
								<a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<button type="submit" class="w-full text-left block px-4 py-2 hover:bg-gray-100">Cerrar sesión</button>
								</form>
							</div>
						</div>
					</div>
				@endauth

				<!-- Mobile menu button -->
				<div class="sm:hidden flex items-center">
					<button @click="open = !open" class="p-2 rounded-md hover:bg-purple-600 transition">
						<svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
							<path x-show="!open" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
							<path x-show="open" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
						</svg>
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Mobile menu -->
	<div x-show="open" class="sm:hidden bg-purple-600">
		<div class="px-4 pt-3 pb-4 space-y-2 text-white">
			<a href="{{ route('dashboard') }}" class="block py-2 hover:text-purple-200">Dashboard</a>
			<a href="{{ route('productos.index') }}" class="block py-2 hover:text-purple-200">Productos</a>
			<a href="{{ route('inventarios.index') }}" class="block py-2 hover:text-purple-200">Inventario</a>
			<a href="{{ route('proveedores.index') }}" class="block py-2 hover:text-purple-200">Proveedores</a>
			<a href="{{ route('clientes.index') }}" class="block py-2 hover:text-purple-200">Clientes</a>
			<a href="{{ route('ventas.index') }}" class="block py-2 hover:text-purple-200">Ventas</a>
			@if(Route::has('informes.ventas'))
				<a href="{{ route('informes.ventas') }}" class="block py-2 hover:text-purple-200">Informes</a>
			@elseif(Route::has('ventas.stats'))
				<a href="{{ route('ventas.stats') }}" class="block py-2 hover:text-purple-200">Informes</a>
			@endif

			<hr class="border-purple-400">

			<a href="{{ route('profile.edit') }}" class="block py-2 hover:text-purple-200">Perfil</a>

			<form method="POST" action="{{ route('logout') }}">
				@csrf
				<button class="w-full text-left py-2 hover:text-purple-200">Cerrar sesión</button>
			</form>
		</div>
	</div>
</nav>
