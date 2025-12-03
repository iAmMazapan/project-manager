<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use App\Traits\RegistraActividad;
//use App\Traits\Autoriza; 

class UsuarioController extends Controller
{
    use AuthorizesRequests;
    use RegistraActividad;
    //use Autoriza;
    
    public function index()
    {
        $this->authorize('viewAny', Usuario::class);
        
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }
    
    public function create()
    {
        $this->authorize('create', Usuario::class);
        
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $this->authorize('create', Usuario::class);
        
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:usuarios',
            'contraseña' => 'required|string|min:8',
            'telefono' => 'nullable|string|max:15',
            'roles' => 'nullable|array',
            'estado' => 'nullable|boolean',
            'es_administrador' => 'nullable|boolean',
        ]);
        
        $usuario = Usuario::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'contraseña' => Hash::make($request->contraseña),
            'telefono' => $request->telefono,
            'estado' => $request->estado ?? true,
            'es_administrador' => $request->es_administrador ?? false,
        ]);
        
        if ($request->has('roles')) {
            $usuario->roles()->attach($request->roles);
        }
        
        $this->registrarActividad(
            auth()->id(), 
            'crear', 
            'usuario', 
            $usuario->id, 
            'Creación del usuario ' . $usuario->nombre_completo
        );
        
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }
    
    public function edit(Usuario $usuario)
    {
        $this->authorize('update', $usuario);
        
        $roles = Rol::all();
        $usuarioRoles = $usuario->roles->pluck('id')->toArray();
        
        return view('usuarios.edit', compact('usuario', 'roles', 'usuarioRoles'));
    }
    
    public function update(Request $request, Usuario $usuario)
    {
        $this->authorize('update', $usuario);
        
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:usuarios,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:15',
            'roles' => 'nullable|array',
            'estado' => 'nullable|boolean',
            'es_administrador' => 'nullable|boolean',
        ]);
        
        $usuario->update([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'estado' => $request->estado ?? $usuario->estado,
            'es_administrador' => $request->es_administrador ?? $usuario->es_administrador,
        ]);
        
        if ($request->has('contraseña') && !empty($request->contraseña)) {
            $usuario->update([
                'contraseña' => Hash::make($request->contraseña),
            ]);
        }
        
        if ($request->has('roles')) {
            $usuario->roles()->sync($request->roles);
        }
        
        $this->registrarActividad(
            auth()->id(), 
            'editar', 
            'usuario', 
            $usuario->id, 
            'Actualización del usuario ' . $usuario->nombre_completo
        );
        
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }
    
    public function destroy(Usuario $usuario)
    {
        $this->authorize('delete', $usuario);
        
        // No permitir eliminar el usuario propio
        if ($usuario->id === auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario');
        }
        
        $nombreUsuario = $usuario->nombre_completo;
        
        $usuario->delete();
        
        $this->registrarActividad(
            auth()->id(), 
            'eliminar', 
            'usuario', 
            $usuario->id, 
            'Eliminación del usuario ' . $nombreUsuario
        );
        
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}