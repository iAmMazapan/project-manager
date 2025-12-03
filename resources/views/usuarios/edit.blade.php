@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('header', 'Editar Usuario')

@section('content')
<div class="pb-5 border-b border-gray-200">
    <h3 class="text-lg leading-6 font-medium text-gray-900">Información del usuario</h3>
</div>

<div class="mt-6">
    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="nombre_completo" class="form-label">Nombre completo</label>
                        <input type="text" name="nombre_completo" id="nombre_completo" value="{{ old('nombre_completo', $usuario->nombre_completo) }}" required class="input-field">
                        @error('nombre_completo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" required class="input-field">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="contraseña" class="form-label">Contraseña (dejar en blanco para mantener la actual)</label>
                        <input type="password" name="contraseña" id="contraseña" class="input-field">
                        @error('contraseña')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6 sm:col-span-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="input-field">
                        @error('telefono')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-6">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="estado" name="estado" type="checkbox" value="1" {{ old('estado', $usuario->estado) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="estado" class="font-medium text-gray-700">Usuario activo</label>
                                <p class="text-gray-500">El usuario podrá acceder al sistema.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-6">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="es_administrador" name="es_administrador" type="checkbox" value="1" {{ old('es_administrador', $usuario->es_administrador) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="es_administrador" class="font-medium text-gray-700">Administrador</label>
                                <p class="text-gray-500">El usuario tendrá acceso a todas las funcionalidades del sistema.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-6">
                        <label class="form-label">Roles</label>
                        <div class="mt-4 space-y-4">
                            @foreach($roles as $rol)
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="rol-{{ $rol->id }}" name="roles[]" type="checkbox" value="{{ $rol->id }}" {{ in_array($rol->id, old('roles', $usuarioRoles)) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="rol-{{ $rol->id }}" class="font-medium text-gray-700">{{ $rol->nombre }}</label>
                                        <p class="text-gray-500">{{ $rol->descripcion }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('usuarios.index') }}" class="btn btn-gray mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-blue">
                    Actualizar
                </button>
            </div>
        </div>
    </form>
</div>
@endsection