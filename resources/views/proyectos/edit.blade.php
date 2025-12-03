@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('header', 'Editar Proyecto')

@section('content')
<div class="pb-5 border-b border-gray-200">
    <h3 class="text-lg leading-6 font-medium text-gray-900">Información del proyecto</h3>
</div>

<div class="mt-6">
    <form action="{{ route('proyectos.update', $proyecto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <label for="titulo" class="form-label">Título del proyecto</label>
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $proyecto->titulo) }}" required class="input-field">
                        @error('titulo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="input-field">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $proyecto->fecha_inicio) }}" class="input-field">
                        @error('fecha_inicio')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $proyecto->fecha_fin) }}" class="input-field">
                        @error('fecha_fin')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6">
                        <label class="form-label">Responsables del proyecto</label>
                        <livewire:proyecto-usuarios-selector :selectedUsuarios="$proyectoUsuarios" />
                        @error('usuarios')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6">
                        <label class="form-label">Archivos asociados</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="archivos" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Subir archivos</span>
                                        <input id="archivos" name="archivos[]" type="file" multiple class="sr-only" accept=".pdf,.doc,.docx,.jpg">
                                    </label>
                                    <p class="pl-1">o arrastralos aquí</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG hasta 10MB</p>
                            </div>
                        </div>
                        @error('archivos.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-gray mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-blue" dusk="actualizar-proyecto-button">
                    Actualizar
                </button>
            </div>
        </div>
    </form>
</div>
@endsection