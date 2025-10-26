<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AudioGestor') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div id="app">
        <!-- Sidebar Navigation -->
        <div class="flex h-screen">
            <!-- Sidebar -->
            <div id="sidebar" class="w-64 bg-gray-800 text-white flex flex-col fixed lg:relative h-full transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">
                <!-- Logo -->
                <div class="p-4 border-b border-gray-700">
                    <h1 class="text-xl font-bold text-blue-400">
                        <i class="fas fa-music mr-2"></i>
                        AudioGestor
                    </h1>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 p-4 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ url('/dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Biblioteca de Audio -->
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-folder mr-3"></i>
                        <span>Biblioteca</span>
                    </a>

                    <!-- Playlists -->
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-list mr-3"></i>
                        <span>Playlists</span>
                    </a>

                    <!-- Subir Archivos -->
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-upload mr-3"></i>
                        <span>Subir Audio</span>
                    </a>

                    <!-- Etiquetas -->
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-tags mr-3"></i>
                        <span>Etiquetas</span>
                    </a>

                    <!-- Estadísticas -->
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-chart-bar mr-3"></i>
                        <span>Estadísticas</span>
                    </a>

                    <!-- Configuración -->
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-cog mr-3"></i>
                        <span>Configuración</span>
                    </a>
                </nav>

                <!-- User Section -->
                <div class="p-4 border-t border-gray-700">
                    @auth
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
                <!-- Top Navigation Bar -->
                <nav class="bg-white shadow-sm border-b border-gray-200">
                    <div class="flex items-center justify-between p-4">
                        <!-- Mobile Menu Button -->
                        <button id="menuToggle" class="lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <!-- Search Bar -->
                        <div class="flex-1 max-w-md lg:ml-4">
                            <div class="relative">
                                <input type="text" 
                                       placeholder="Buscar archivos de audio..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Right Side Navigation -->
                        <div class="flex items-center space-x-4">
                            <!-- Quick Actions -->
                            <div class="flex space-x-2">
                                <button class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fas fa-upload"></i>
                                </button>
                                <button class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <button class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fas fa-sort"></i>
                                </button>
                            </div>

                            <!-- User Menu -->
                            <div class="flex items-center space-x-3">
                                @guest
                                    @if (Route::has('login'))
                                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition-colors">
                                            {{ __('Login') }}
                                        </a>
                                    @endif

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                            {{ __('Register') }}
                                        </a>
                                    @endif
                                @else
                                    <div class="relative">
                                        <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition-colors">
                                            <span>{{ Auth::user()->name }}</span>
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </button>
                                        
                                        <!-- Dropdown Menu -->
                                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 hidden">
                                            <a href="{{ route('logout') }}" 
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                                {{ __('cerrar sesión') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Main Content Area -->
                <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                    @yield('content')
                </main>
            </div>
        </div>

        <!-- Mobile menu overlay -->
        <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>
    </div>

    <!-- Font Awesome for Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const menuToggle = document.getElementById('menuToggle');
            const userMenuButton = document.querySelector('button.flex.items-center.space-x-2');
            const dropdownMenu = document.querySelector('.absolute.hidden');

            // Mobile menu toggle
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    mobileOverlay.classList.toggle('hidden');
                });
            }

            // Close sidebar when clicking overlay
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                });
            }

            // User dropdown functionality
            if (userMenuButton && dropdownMenu) {
                userMenuButton.addEventListener('click', function() {
                    dropdownMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }

            // Close sidebar on window resize (if needed)
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script>
</body>
</html>
