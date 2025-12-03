@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
    <!-- Tarjeta de proyectos -->
    <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-900 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Proyectos</dt>
                        <dd>
                            <div class="text-3xl font-bold text-gray-900">{{ $totalProyectos }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('proyectos.index') }}" class="font-medium text-slate-700 hover:text-slate-900">Ver todos</a>
            </div>
        </div>
    </div>

    <!-- Tarjeta de tareas -->
    <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-900 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Tareas</dt>
                        <dd>
                            <div class="text-3xl font-bold text-gray-900">{{ $totalTareas }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('tareas.index') }}" class="font-medium text-slate-700 hover:text-slate-900">Ver todas</a>
            </div>
        </div>
    </div>

    @if(auth()->user()->esAdministrador())
    <!-- Tarjeta de usuarios (solo para administradores) -->
    <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-900 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Usuarios</dt>
                        <dd>
                            <div class="text-3xl font-bold text-gray-900">{{ $totalUsuarios }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('usuarios.index') }}" class="font-medium text-slate-700 hover:text-slate-900">Ver todos</a>
            </div>
        </div>
    </div>
    @else
    <!-- Tarjeta de tareas completadas (para usuarios normales) -->
    <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-amber-900 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Tareas completadas</dt>
                        <dd>
                            <div class="text-3xl font-bold text-gray-900">{{ $tareasPorEstado['completada'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('tareas.index') }}" class="font-medium text-slate-700 hover:text-slate-900">Ver tareas</a>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Estado de tareas -->
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="border-b border-gray-200 p-5">
            <h3 class="text-lg font-medium text-gray-900">Estado de tareas</h3>
        </div>
        <div class="p-5">
            <div class="space-y-6">
                <div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-700">Por hacer</p>
                        <span class="text-sm font-medium text-gray-900">{{ $tareasPorEstado['por hacer'] }} tareas</span>
                    </div>
                    <div class="mt-2 relative pt-1">
                        @php
                            $total = array_sum($tareasPorEstado);
                            $porHacerPorcentaje = $total > 0 ? ($tareasPorEstado['por hacer'] / $total) * 100 : 0;
                        @endphp
                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                            <div style="width: {{ $porHacerPorcentaje }}%" class="shadow-none flex flex-col justify-center text-white text-center whitespace-nowrap bg-blue-900 rounded"></div>
                        </div>
                        <p class="mt-1 text-xs text-gray-600">{{ number_format($porHacerPorcentaje, 1) }}%</p>
                    </div>
                </div>
                
                <div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-700">En progreso</p>
                        <span class="text-sm font-medium text-gray-900">{{ $tareasPorEstado['en progreso'] }} tareas</span>
                    </div>
                    <div class="mt-2 relative pt-1">
                        @php
                            $enProgresoPorcentaje = $total > 0 ? ($tareasPorEstado['en progreso'] / $total) * 100 : 0;
                        @endphp
                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                            <div style="width: {{ $enProgresoPorcentaje }}%" class="shadow-none flex flex-col justify-center text-white text-center whitespace-nowrap bg-amber-500 rounded"></div>
                        </div>
                        <p class="mt-1 text-xs text-gray-600">{{ number_format($enProgresoPorcentaje, 1) }}%</p>
                    </div>
                </div>
                
                <div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-700">Completadas</p>
                        <span class="text-sm font-medium text-gray-900">{{ $tareasPorEstado['completada'] }} tareas</span>
                    </div>
                    <div class="mt-2 relative pt-1">
                        @php
                            $completadasPorcentaje = $total > 0 ? ($tareasPorEstado['completada'] / $total) * 100 : 0;
                        @endphp
                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                            <div style="width: {{ $completadasPorcentaje }}%" class="shadow-none flex flex-col justify-center text-white text-center whitespace-nowrap bg-green-500 rounded"></div>
                        </div>
                        <p class="mt-1 text-xs text-gray-600">{{ number_format($completadasPorcentaje, 1) }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Proyectos recientes -->
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="border-b border-gray-200 p-5">
            <h3 class="text-lg font-medium text-gray-900">Proyectos recientes</h3>
        </div>
        <div class="p-5">
            @if($proyectosRecientes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha inicio</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha fin</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($proyectosRecientes as $proyecto)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('proyectos.show', $proyecto) }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">
                                            {{ $proyecto->titulo }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $proyecto->fecha_inicio ? date('d/m/Y', strtotime($proyecto->fecha_inicio)) : 'Sin definir' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $proyecto->fecha_fin ? date('d/m/Y', strtotime($proyecto->fecha_fin)) : 'Sin definir' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay proyectos recientes</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Comienza por crear un nuevo proyecto.
                    </p>
                    @can('create', App\Models\Proyecto::class)
                    <div class="mt-6">
                        <a href="{{ route('proyectos.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Nuevo proyecto
                        </a>
                    </div>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Tareas recientes -->
<div class="mt-8">
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="border-b border-gray-200 p-5">
            <h3 class="text-lg font-medium text-gray-900">Tareas recientes</h3>
        </div>
        <div class="p-5">
            @if($tareasRecientes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha fin</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tareasRecientes as $tarea)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('tareas.show', $tarea) }}" class="text-sm font-medium text-slate-700 hover:text-slate-900">
                                            {{ $tarea->titulo }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="text-sm text-slate-700 hover:text-slate-900">
                                            {{ $tarea->proyecto->titulo }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tarea->usuario->nombre_completo }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $tarea->estado === 'completada' ? 'bg-green-100 text-green-800' :
                                              ($tarea->estado === 'en progreso' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-800') }}">
                                            {{ ucfirst($tarea->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tarea->fecha_fin ? date('d/m/Y', strtotime($tarea->fecha_fin)) : 'Sin definir' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay tareas recientes</h3>
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
            @endif
        </div>
    </div>
</div>
@endsection