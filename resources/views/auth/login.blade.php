<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen antialiased">
    <div class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-14 w-14 rounded-xl bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Sistema de Administración</h2>
                <p class="mt-2 text-sm text-gray-600">de Proyectos</p>
            </div>

            <!-- Form -->
            <div class="mt-8 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <div class="px-8 py-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2">
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-600 sm:text-sm sm:leading-6"
                                    placeholder="tu@email.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Contraseña</label>
                            <div class="mt-2">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-600 sm:text-sm sm:leading-6">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    id="remember"
                                    name="remember"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-slate-600 focus:ring-slate-600">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">Recordarme</label>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a href="{{ route('password.request') }}" class="font-medium text-slate-700 hover:text-slate-900">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="flex w-full justify-center rounded-md bg-gradient-to-r from-slate-700 to-slate-900 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:from-slate-800 hover:to-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600 transition-all">
                                Iniciar sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <p class="text-center text-sm text-gray-500">
                Gestión profesional de proyectos y tareas
            </p>
        </div>
    </div>
</body>
</html>
