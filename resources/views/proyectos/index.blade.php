@extends('layouts.app')

@section('title', 'Proyectos')

@section('header', 'Proyectos')

@section('header_buttons')
    @can('create', App\Models\Proyecto::class)
    <a href="{{ route('proyectos.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 mt-4 sm:mt-0" dusk="crear-proyecto-link">
        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo proyecto
    </a>
    @endcan
@endsection

@section('content')
<div class="mt-4">
    @if($proyectos->count() > 0)
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($proyectos as $proyecto)
                <div class="bg-white shadow overflow-hidden rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex justify-between">
                            <h3 class="text-lg font-medium text-gray-900 truncate">
                                <a href="{{ route('proyectos.show', $proyecto) }}" class="hover:text-slate-700">
                                    {{ $proyecto->titulo }}
                                </a>
                            </h3>
                            
                            @php
                                $totalTareas = $proyecto->tareas->count();
                                $tareasCompletadas = $proyecto->tareas->where('estado', 'completada')->count();
                                $porcentaje = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;
                            @endphp
                            
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $porcentaje === 100 ? 'bg-green-100 text-green-800' : ($porcentaje > 50 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-800') }}">
                                {{ $porcentaje }}% Completado
                            </span>
                        </div>
                        
                        <p class="mt-2 max-w-2xl text-sm text-gray-500 line-clamp-2 h-10">
                            {{ $proyecto->descripcion ?: 'Sin descripción' }}
                        </p>
                        
                        <div class="mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-slate-700 h-2.5 rounded-full" style="width: {{ $porcentaje }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                            <div class="flex space-x-4">
                                <div>
                                    <span class="font-medium text-gray-900">Inicio:</span> {{ $proyecto->fecha_inicio ? date('d/m/Y', strtotime($proyecto->fecha_inicio)) : 'Sin definir' }}
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900">Fin:</span> {{ $proyecto->fecha_fin ? date('d/m/Y', strtotime($proyecto->fecha_fin)) : 'Sin definir' }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-500">{{ $totalTareas }} tarea(s)</span>
                            </div>
                            
                            <a href="{{ route('proyectos.show', $proyecto) }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg py-10">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay proyectos</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Comienza por crear un nuevo proyecto.
                </p>
                @can('create', App\Models\Proyecto::class)
                <div class="mt-6">
                    <a href="{{ route('proyectos.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500" dusk="crear-proyecto-link">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nuevo proyecto
                    </a>
                </div>
                @endcan
            </div>
        </div>
    @endif
</div>
@endsection