<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

        <!-- Header con logo -->
        <div class="bg-gradient-to-r from-[#7B2CBF] to-[#9D4EDD] px-8 py-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="bg-white p-3 rounded-2xl shadow-lg">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Fresas con Crema" class="h-16 w-16 object-contain">
                </div>
            </div>
            <h2 class="text-2xl font-bold text-white">Bienvenido</h2>
            <p class="text-purple-100 text-sm mt-1">Inicia sesión para continuar</p>
        </div>

        <!-- Form section -->
        <div class="px-8 py-8">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <x-text-input id="email"
                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg border-gray-300 focus:border-[#7B2CBF] focus:ring-2 focus:ring-[#7B2CBF]/20 transition duration-200"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            placeholder="tu@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <x-text-input id="password"
                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg border-gray-300 focus:border-[#7B2CBF] focus:ring-2 focus:ring-[#7B2CBF]/20 transition duration-200"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer group">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-[#7B2CBF] shadow-sm focus:ring-[#7B2CBF] transition duration-200"
                            name="remember">
                        <span class="text-gray-600 group-hover:text-gray-800 transition duration-200">Recuérdame</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-[#7B2CBF] hover:text-[#9D4EDD] font-medium transition duration-200"
                            href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Submit button -->
                <div class="pt-2">
                    <x-primary-button
                        class="w-full justify-center bg-gradient-to-r from-[#7B2CBF] to-[#9D4EDD] hover:from-[#6A1FA8] hover:to-[#8B3FC7] text-white font-semibold py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
                        INICIAR SESIÓN
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-6 text-center border-t border-gray-100">
            <p class="text-sm text-gray-600">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}"
                    class="text-[#7B2CBF] hover:text-[#9D4EDD] font-semibold transition duration-200">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
