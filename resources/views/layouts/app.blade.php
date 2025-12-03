<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema Administración de Proyectos') }} - @yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen">
        <!-- Sidebar Desktop -->
        <aside class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-96 lg:flex-col">
            <div class="flex grow flex-col overflow-y-auto bg-white border-r border-gray-200">
                <!-- User Profile Section -->
                <div class="flex flex-col items-center px-8 pt-12 pb-10 border-b border-gray-200">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center mb-6 shadow-lg ring-4 ring-gray-100">
                        <div class="w-28 h-28 rounded-full bg-gradient-to-br from-slate-600 to-slate-800 text-white flex items-center justify-center font-bold text-5xl">
                            {{ substr(auth()->user()->nombre_completo, 0, 1) }}
                        </div>
                    </div>
                    <h3 class="text-gray-900 font-bold text-xl text-center mb-2">{{ auth()->user()->nombre_completo }}</h3>
                    <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                </div>

                <!-- Navigation -->
                <nav class="flex flex-1 flex-col px-8 py-8">
                    <ul role="list" class="space-y-2">
                        @include('layouts.navigation')
                    </ul>
                </nav>

                <!-- Logout -->
                <div class="border-t border-gray-200 p-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile menu button -->
        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden border-b border-gray-200">
            <button type="button" id="mobile-menu-btn" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                <span class="sr-only">Abrir menú</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <div class="flex-1 text-sm font-semibold text-gray-900">
                @yield('header')
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="relative z-50 lg:hidden hidden" role="dialog" aria-modal="true">
            <div id="mobile-overlay" class="fixed inset-0 bg-gray-900/80"></div>
            <div class="fixed inset-0 flex">
                <div class="relative mr-16 flex w-full max-w-xs flex-1">
                    <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button type="button" id="close-menu-btn" class="-m-2.5 p-2.5">
                            <span class="sr-only">Cerrar menú</span>
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white">
                        <div class="flex h-16 shrink-0 items-center px-6 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-slate-700 to-slate-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-900 text-sm">Proyectos</span>
                            </div>
                        </div>
                        <nav class="flex flex-1 flex-col px-4">
                            <ul role="list" class="space-y-1">
                                @include('layouts.navigation')
                            </ul>
                        </nav>
                        <div class="border-t border-gray-200 p-4">
                            <div class="flex items-center gap-3 px-3 py-2 rounded-lg bg-gray-50">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-slate-600 to-slate-800 text-white flex items-center justify-center font-semibold text-sm">
                                    {{ substr(auth()->user()->nombre_completo, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->nombre_completo }}</p>
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-gray-500 hover:text-gray-700">Cerrar sesión</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="lg:pl-96">
            <div class="px-8 py-10 sm:px-10 lg:px-12">
                <div class="max-w-7xl">
                    <!-- Page header -->
                    <div class="mb-6">
                        <div class="sm:flex sm:items-center sm:justify-between">
                            <div class="min-w-0 flex-1">
                                <h1 class="text-2xl font-bold text-gray-900">@yield('header')</h1>
                            </div>
                            <div class="mt-4 flex sm:ml-4 sm:mt-0">
                                @yield('header_buttons')
                            </div>
                        </div>
                    </div>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 rounded-lg bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex rounded-md bg-red-50 p-1.5 text-red-500 hover:bg-red-100 focus:outline-none">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                    <!-- Page content -->
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileOverlay = document.getElementById('mobile-overlay');

        mobileMenuBtn?.addEventListener('click', () => {
            mobileMenu?.classList.remove('hidden');
        });

        closeMenuBtn?.addEventListener('click', () => {
            mobileMenu?.classList.add('hidden');
        });

        mobileOverlay?.addEventListener('click', () => {
            mobileMenu?.classList.add('hidden');
        });

        setTimeout(() => {
            document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]').forEach(el => {
                if (el.querySelector('button[onclick*="remove"]')) {
                    el.remove();
                }
            });
        }, 5000);
    </script>
</body>
</html>
