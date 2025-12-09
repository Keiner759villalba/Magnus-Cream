<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#7B2CBF] py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="relative z-10 w-full max-w-md mx-auto">
            
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden p-8">
                
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12">
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                            <x-text-input id="email" class="block mt-1 w-full rounded border-gray-300 focus:border-[#7B2CBF] focus:ring-[#7B2CBF]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                            <x-text-input id="password" class="block mt-1 w-full rounded border-gray-300 focus:border-[#7B2CBF] focus:ring-[#7B2CBF]"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center gap-2">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#7B2CBF] shadow-sm focus:ring-[#7B2CBF]" name="remember">
                                <span class="text-sm text-gray-600">Recuérdame</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-[#7B2CBF] hover:underline" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button class="w-full justify-center bg-[#7B2CBF] hover:bg-purple-600 transition duration-150 py-2.5">
                                INICIAR SESIÓN
                            </x-primary-button>
                        </div>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-[#7B2CBF] hover:underline font-medium">Regístrate</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>