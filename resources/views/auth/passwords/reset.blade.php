<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Restablecer Contraseña - AudioGestor</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            /* CSS completo del login... */
        </style>
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md mx-4">
        <!-- Logo y Título -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-music text-white text-2xl"></i>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                AudioGestor
            </h1>
            <p class="text-[#706f6c] dark:text-[#A1A09A]">
                Restablece tu contraseña
            </p>
        </div>

        <!-- Formulario de Restablecimiento -->
        <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-6">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Correo Electrónico
                    </label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ $email ?? old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           class="w-full px-3 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm bg-transparent text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] dark:placeholder-[#A1A09A] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-[#f53003] dark:border-[#FF4433] @enderror"
                           placeholder="tu@email.com">
                    
                    @error('email')
                        <p class="mt-1 text-sm text-[#f53003] dark:text-[#FF4433]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nueva Contraseña -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Nueva Contraseña
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-3 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm bg-transparent text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] dark:placeholder-[#A1A09A] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-[#f53003] dark:border-[#FF4433] @enderror"
                           placeholder="••••••••">
                    
                    @error('password')
                        <p class="mt-1 text-sm text-[#f53003] dark:text-[#FF4433]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-6">
                    <label for="password-confirm" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Confirmar Contraseña
                    </label>
                    <input id="password-confirm"
                           type="password"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           class="w-full px-3 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm bg-transparent text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] dark:placeholder-[#A1A09A] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="••••••••">
                </div>

                <!-- Botón de Restablecimiento -->
                <button type="submit"
                        class="w-full bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] py-2 px-4 rounded-sm font-medium hover:bg-black dark:hover:bg-white transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Restablecer Contraseña
                </button>

                <!-- Enlace a Login -->
                @if (Route::has('login'))
                    <div class="mt-4 text-center">
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium transition-colors">
                                ← Volver al inicio de sesión
                            </a>
                        </p>
                    </div>
                @endif
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center">
            <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                &copy; {{ date('Y') }} AudioGestor. Todos los derechos reservados.
            </p>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
