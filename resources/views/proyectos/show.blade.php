@extends('layouts.app')

@section('title', $proyecto->titulo)

@section('header')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div>
            {{ $proyecto->titulo }}
        </div>
        <div class="mt-2 sm:mt-0 flex">
            @can('update', $proyecto)
            <a href="{{ route('proyectos.edit', $proyecto) }}" class="btn btn-gray mr-2">
                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar
            </a>
            @endcan
            
            @can('create', App\Models\Tarea::class)
            <a href="{{ route('tareas.create', ['proyecto_id' => $proyecto->id]) }}" class="btn btn-blue">
                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nueva tarea
            </a>
            @endcan
        </div>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Información del proyecto</h3>
                
                @php
                    $totalTareas = $proyecto->tareas->count();
                    $tareasCompletadas = $proyecto->tareas->where('estado', 'completada')->count();
                    $porcentaje = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;
                @endphp
                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $porcentaje === 100 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $porcentaje }}% Completado
                </div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Fecha de inicio</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $proyecto->fecha_inicio ? date('d/m/Y', strtotime($proyecto->fecha_inicio)) : 'Sin definir' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Fecha de finalización</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $proyecto->fecha_fin ? date('d/m/Y', strtotime($proyecto->fecha_fin)) : 'Sin definir' }}</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-500">Descripción</p>
                    <div class="mt-1 text-sm text-gray-900">
                        {{ $proyecto->descripcion ?: 'Sin descripción' }}
                    </div>
                </div>
                
                <div class="mt-6">
                    <p class="text-sm font-medium text-gray-500">Progreso del proyecto</p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $porcentaje }}%"></div>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">
                            {{ $tareasCompletadas }} de {{ $totalTareas }} tareas completadas
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Archivos del proyecto</h3>
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
                                        
                                        @can('update', $proyecto)
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
                    
                    @can('update', $proyecto)
                        <div class="mt-4">
                            <livewire:archivo-uploader :entidadId="$proyecto->id" :tipoEntidad="'proyecto'" />
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Responsables</h3>
            </div>
            <div class="card-body">
                @if($proyecto->usuarios->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($proyecto->usuarios as $usuario)
                            <li class="py-3 flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-600">
                                        <span class="text-lg font-medium leading-none text-white">
                                            {{ substr($usuario->nombre_completo, 0, 1) }}
                                        </span>
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $usuario->nombre_completo }}</p>
                                    <p class="text-xs text-gray-500">{{ $usuario->email }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">No hay responsables asignados.</p>
                @endif
            </div>
        </div>
        
        <div class="mt-6 card">
            <div class="card-header">
                <h3 class="text-lg font-medium text-gray-900">Estado de tareas</h3>
            </div>
            <div class="card-body">
                <div class="space-y-3">
                    @php
                        $porHacer = $proyecto->tareas->where('estado', 'por hacer')->count();
                        $enProgreso = $proyecto->tareas->where('estado', 'en progreso')->count();
                        $completadas = $proyecto->tareas->where('estado', 'completada')->count();
                    @endphp
                    
                    <div>
                        <div class="flex justify-between items-center">
                            <div class="inline-flex items-center">
                                <span class="h-3 w-3 bg-blue-500 rounded-full mr-2"></span>
                                <span class="text-sm text-gray-700">Por hacer</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $porHacer }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center">
                            <div class="inline-flex items-center">
                                <span class="h-3 w-3 bg-yellow-500 rounded-full mr-2"></span>
                                <span class="text-sm text-gray-700">En progreso</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $enProgreso }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center">
                            <div class="inline-flex items-center">
                                <span class="h-3 w-3 bg-green-500 rounded-full mr-2"></span>
                                <span class="text-sm text-gray-700">Completadas</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $completadas }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 card">
            <div class="card-body">
                <div class="space-y-3">
                    @can('update', $proyecto)
                        <a href="{{ route('proyectos.edit', $proyecto) }}" class="flex items-center text-blue-600 hover:text-blue-900">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar proyecto
                        </a>
                    @endcan
                    
                    @can('create', App\Models\Tarea::class)
                        <a href="{{ route('tareas.create', ['proyecto_id' => $proyecto->id]) }}" class="flex items-center text-blue-600 hover:text-blue-900">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Crear nueva tarea
                        </a>
                    @endcan
                    
                    @can('delete', $proyecto)
                        <form method="POST" action="{{ route('proyectos.destroy', $proyecto) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center text-red-600 hover:text-red-900" dusk="delete-button-{{ $proyecto->id }}" onclick="return confirm('¿Estás seguro de que deseas eliminar este proyecto? Se eliminarán todas las tareas asociadas.')">
                                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Eliminar proyecto
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-6">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Tareas del proyecto</h3>
            
            @can('create', App\Models\Tarea::class)
                <a href="{{ route('tareas.create', ['proyecto_id' => $proyecto->id]) }}" class="btn btn-blue btn-sm">
                    <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nueva tarea
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if($tareas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha inicio</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha fin</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tareas as $tarea)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-blue-600">
                                            <a href="{{ route('tareas.show', $tarea) }}">{{ $tarea->titulo }}</a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $tarea->usuario->nombre_completo }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $tarea->fecha_inicio ? date('d/m/Y', strtotime($tarea->fecha_inicio)) : 'Sin definir' }}</div>
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
                                                  ($tarea->estado === 'en progreso' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($tarea->estado) }}
                                            </span>
                                        @endcan
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('tareas.show', $tarea) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                        
                                        @can('update', $tarea)
                                            <a href="{{ route('tareas.edit', $tarea) }}" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
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
                <div class="text-center py-4">
                    <svg class="mx-auto h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-2 text-sm font-medium text-gray-900">No hay tareas en este proyecto</p>
                    <p class="mt-1 text-sm text-gray-500">Comienza por crear una nueva tarea.</p>
                    
                    @can('create', App\Models\Tarea::class)
                        <div class="mt-4">
                            <a href="{{ route('tareas.create', ['proyecto_id' => $proyecto->id]) }}" class="btn btn-blue">
                                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nueva tarea
                            </a>
                        </div>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</div>
@endsection