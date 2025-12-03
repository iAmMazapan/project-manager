@extends('layouts.app')

@section('title', 'Tareas')

@section('header', 'Tareas')

@section('header_buttons')
    @can('create', App\Models\Tarea::class)
    <a href="{{ route('tareas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nueva tarea
    </a>
    @endcan
@endsection

@section('content')

<div class="mt-8">
    @if($tareas->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha fin</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tareas as $tarea)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-700">
                                    <a href="{{ route('tareas.show', $tarea) }}" class="hover:text-slate-900">{{ $tarea->titulo }}</a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="text-slate-700 hover:text-slate-900">
                                        {{ $tarea->proyecto->titulo }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $tarea->usuario->nombre_completo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $tarea->fecha_fin ? date('d/m/Y', strtotime($tarea->fecha_fin)) : 'Sin definir' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @can('update', $tarea)
                                    <livewire:tarea-estado-selector :tarea="$tarea" :wire:key="'tarea-'.$tarea->id" />
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $tarea->estado === 'completada' ? 'bg-green-100 text-green-800' :
                                          ($tarea->estado === 'en progreso' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-800') }}">
                                        {{ ucfirst($tarea->estado) }}
                                    </span>
                                @endcan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('tareas.show', $tarea) }}" class="text-slate-700 hover:text-slate-900 mr-3">Ver</a>

                                @can('update', $tarea)
                                    <a href="{{ route('tareas.edit', $tarea) }}" class="text-slate-700 hover:text-slate-900 mr-3">Editar</a>
                                @endcan
                                
                                @can('delete', $tarea)
                                    <form method="POST" action="{{ route('tareas.destroy', $tarea) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-16">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay tareas</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Comienza por crear una nueva tarea.
                </p>
                @can('create', App\Models\Tarea::class)
                <div class="mt-6">
                    <a href="{{ route('tareas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nueva tarea
                    </a>
                </div>
                @endcan
            </div>
        </div>
    @endif
</div>
@endsection