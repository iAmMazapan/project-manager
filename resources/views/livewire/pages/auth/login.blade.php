<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8">
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

        @if (session('status'))
            <div class="rounded-lg bg-green-50 p-4 border border-green-200">
                <p class="text-sm text-green-800 text-center">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Form -->
        <div class="mt-8 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="px-8 py-8">
                <form wire:submit="login" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input
                                wire:model="form.email"
                                id="email"
                                type="email"
                                required
                                autofocus
                                autocomplete="username"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-600 sm:text-sm sm:leading-6"
                                placeholder="tu@email.com">
                            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Contraseña</label>
                        <div class="mt-2">
                            <input
                                wire:model="form.password"
                                id="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-600 sm:text-sm sm:leading-6">
                            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                wire:model="form.remember"
                                id="remember"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-slate-600 focus:ring-slate-600">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Recordarme</label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" wire:navigate class="font-medium text-slate-700 hover:text-slate-900">
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
