@extends('layouts.app')

@section('title', 'Crear Tarea')

@section('header', 'Crear Tarea')

@section('content')
<div class="pb-5 border-b border-gray-200">
    <h3 class="text-lg leading-6 font-medium text-gray-900">Información de la tarea</h3>
</div>

<div class="mt-6">
    <form action="{{ route('tareas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <label for="titulo" class="form-label">Título de la tarea</label>
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required class="input-field">
                        @error('titulo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="input-field">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="proyecto_id" class="form-label">Proyecto</label>
                        <select name="proyecto_id" id="proyecto_id" required class="input-field">
                            <option value="">Seleccionar proyecto</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}" {{ old('proyecto_id', $proyectoId) == $proyecto->id ? 'selected' : '' }}>
                                    {{ $proyecto->titulo }}
                                </option>
                            @endforeach
                        </select>
                        @error('proyecto_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="usuario_id" class="form-label">Responsable</label>
                        <select name="usuario_id" id="usuario_id" required class="input-field">
                            <option value="">Seleccionar responsable</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                        @error('usuario_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" min="{{ date('Y-m-d') }}" class="input-field">
                        @error('fecha_inicio')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" min="{{ date('Y-m-d') }}" class="input-field">
                        @error('fecha_fin')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" required class="input-field">
                            <option value="por hacer" {{ old('estado') == 'por hacer' ? 'selected' : '' }}>Por hacer</option>
                            <option value="en progreso" {{ old('estado') == 'en progreso' ? 'selected' : '' }}>En progreso</option>
                            <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                        </select>
                        @error('estado')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6">
                        <label class="form-label">Archivos asociados</label>
                        <label for="archivos" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-slate-500 hover:bg-slate-100 transition-all cursor-pointer">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <span class="font-medium text-slate-700">Subir archivos</span>
                                    <input id="archivos" name="archivos[]" type="file" multiple class="sr-only" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <p class="pl-1">o arrastralos aquí</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, PNG hasta 10MB</p>
                            </div>
                        </label>
                        <div id="archivos-seleccionados" class="mt-3 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Archivos seleccionados:</p>
                            <ul id="lista-archivos" class="text-sm text-gray-600 space-y-1"></ul>
                        </div>
                        @error('archivos.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('tareas.index') }}" class="btn btn-gray mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-blue">
                    Guardar
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const proyectoSelect = document.getElementById('proyecto_id');
    const usuarioSelect = document.getElementById('usuario_id');

    proyectoSelect.addEventListener('change', function() {
        const proyectoId = this.value;

        if (proyectoId) {
            // Aquí podrías hacer una petición AJAX para obtener los usuarios del proyecto
            // Como simplificación, solo refrescamos la página pasando el proyecto_id
            window.location.href = "{{ route('tareas.create') }}?proyecto_id=" + proyectoId;
        }
    });

    // Mejorar inputs de fecha
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');

    if (fechaInicio && fechaFin) {
        // Establecer fecha mínima en fecha de fin cuando se selecciona fecha de inicio
        fechaInicio.addEventListener('change', function() {
            fechaFin.min = this.value;
        });

        // Validar que la fecha de fin no sea anterior a la de inicio
        fechaFin.addEventListener('change', function() {
            if (fechaInicio.value && this.value < fechaInicio.value) {
                alert('La fecha de finalización no puede ser anterior a la fecha de inicio');
                this.value = '';
            }
        });
    }

    // Mostrar archivos seleccionados
    const inputArchivos = document.getElementById('archivos');
    const divArchivos = document.getElementById('archivos-seleccionados');
    const listaArchivos = document.getElementById('lista-archivos');

    if (inputArchivos) {
        inputArchivos.addEventListener('change', function() {
            const archivos = this.files;

            if (archivos.length > 0) {
                listaArchivos.innerHTML = '';
                divArchivos.classList.remove('hidden');

                Array.from(archivos).forEach((archivo, index) => {
                    const li = document.createElement('li');
                    li.className = 'flex items-center gap-2';
                    li.innerHTML = `
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>${archivo.name} (${(archivo.size / 1024).toFixed(2)} KB)</span>
                    `;
                    listaArchivos.appendChild(li);
                });
            } else {
                divArchivos.classList.add('hidden');
            }
        });
    }
});
</script>
@endpush
@endsection