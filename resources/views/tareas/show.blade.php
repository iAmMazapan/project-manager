@extends('layouts.app')

@section('title', $tarea->titulo)

@section('header')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div>
            {{ $tarea->titulo }}
        </div>
        <div class="mt-2 sm:mt-0 flex">
            @can('update', $tarea)
            <a href="{{ route('tareas.edit', $tarea) }}" class="btn btn-gray mr-2">
                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar
            </a>
            @endcan
            
            <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="btn btn-blue">
                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al proyecto
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Información de la tarea -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Información de la tarea</h3>
                
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $tarea->estado === 'completada' ? 'bg-green-100 text-green-800' : 
                    ($tarea->estado === 'en progreso' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                    {{ ucfirst($tarea->estado) }}
                </span>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Proyecto</p>
                        <p class="mt-1 text-sm text-blue-600">
                            <a href="{{ route('proyectos.show', $tarea->proyecto) }}">{{ $tarea->proyecto->titulo }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Responsable</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $tarea->usuario->nombre_completo }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Fecha de inicio</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $tarea->fecha_inicio ? date('d/m/Y', strtotime($tarea->fecha_inicio)) : 'Sin definir' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Fecha de finalización</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $tarea->fecha_fin ? date('d/m/Y', strtotime($tarea->fecha_fin)) : 'Sin definir' }}</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-500">Descripción</p>
                    <div class="mt-1 text-sm text-gray-900">
                        {{ $tarea->descripcion ?: 'Sin descripción' }}
                    </div>
                </div>
                
                @can('update', $tarea)
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-500">Actualizar estado</p>
                    <div class="mt-1">
                        <form action="{{ route('tareas.actualizar-estado', $tarea) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PATCH')
                            <select name="estado" class="mr-2 input-field">
                                <option value="por hacer" {{ $tarea->estado === 'por hacer' ? 'selected' : '' }}>Por hacer</option>
                                <option value="en progreso" {{ $tarea->estado === 'en progreso' ? 'selected' : '' }}>En progreso</option>
                                <option value="completada" {{ $tarea->estado === 'completada' ? 'selected' : '' }}>Completada</option>
                            </select>
                            <button type="submit" class="btn btn-blue">
                                Actualizar
                            </button>
                        </form>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        
        <!-- Archivos asociados a la tarea -->
        <div class="mt-6">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Archivos de la tarea</h3>
                </div>
                <div class="card-body">
                    @if($archivos->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($archivos as $archivo)
                                <li class="py-4 flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @php
                                                $icono = 'document-text';
                                                if ($archivo->tipo_archivo === 'pdf') {
                                                    $icono = 'document-text';
                                                } elseif (in_array($archivo->tipo_archivo, ['doc', 'docx'])) {
                                                    $icono = 'document';
                                                } elseif ($archivo->tipo_archivo === 'jpg') {
                                                    $icono = 'photograph';
                                                }
                                            @endphp
                                            <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $archivo->nombre }}</p>
                                            <p class="text-sm text-gray-500">{{ strtoupper($archivo->tipo_archivo) }} - {{ date('d/m/Y', strtotime($archivo->fecha_subida)) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <a href="{{ route('archivos.download', $archivo) }}" class="text-blue-600 hover:text-blue-900 mr-4">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                        
                                        @can('update', $tarea)
                                            <form method="POST" action="{{ route('archivos.destroy', $archivo) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que deseas eliminar este archivo?')">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4">
                            <svg class="mx-auto h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900">No hay archivos asociados</p>
                        </div>
                    @endif
                    
                    @can('update', $tarea)
                        <div class="mt-4">
                            <livewire:archivo-uploader :entidadId="$tarea->id" :tipoEntidad="'tarea'" />
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar derecha -->
    <div class="lg:col-span-1">
        <!-- Acciones -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Acciones</h3>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    @can('update', $tarea)
                        <a href="{{ route('tareas.edit', $tarea) }}" class="flex items-center text-blue-600 hover:text-blue-900">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar tarea
                        </a>
                    @endcan
                    
                    <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="flex items-center text-blue-600 hover:text-blue-900">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        Ver proyecto
                    </a>
                    
                    @can('delete', $tarea)
                        <form method="POST" action="{{ route('tareas.destroy', $tarea) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">
                                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Eliminar tarea
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
        
        <!-- Información adicional -->
        <div class="mt-6 card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Información adicional</h3>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Creado en</p>
                        <p class="text-sm text-gray-900">{{ date('d/m/Y H:i', strtotime($tarea->fecha_creacion)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Última actualización</p>
                        <p class="text-sm text-gray-900">{{ date('d/m/Y H:i', strtotime($tarea->fecha_actualizacion)) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection