<?php

namespace App\Policies;

use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class TareaPolicy
{
    use HandlesAuthorization;

    public function viewAny(Usuario $usuario)
    {
        return true; // Todos pueden ver la lista de tareas (filtrada por permisos)
    }

    public function view(Usuario $usuario, Tarea $tarea)
    {
        return $usuario->esAdministrador() || 
               $tarea->proyecto->usuarios->contains($usuario->id) || 
               $tarea->usuario_id === $usuario->id;
    }

    public function create(Usuario $usuario)
    {
        return true; // Todos pueden crear tareas (verificación adicional en el controlador)
    }

    public function update(Usuario $usuario, Tarea $tarea)
    {
        return $usuario->esAdministrador() || 
               $tarea->proyecto->usuarios->contains($usuario->id) || 
               $tarea->usuario_id === $usuario->id;
    }

    public function delete(Usuario $usuario, Tarea $tarea)
    {
        return $usuario->esAdministrador() || 
               ($usuario->tieneRol('Responsable de proyecto') && $tarea->proyecto->usuarios->contains($usuario->id));
    }
}