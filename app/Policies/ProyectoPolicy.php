<?php

namespace App\Policies;

use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProyectoPolicy
{
    use HandlesAuthorization;

    public function viewAny(Usuario $usuario)
    {
        return true; // Todos pueden ver la lista de proyectos (filtrada por permisos)
    }

    public function view(Usuario $usuario, Proyecto $proyecto)
    {
        return $usuario->esAdministrador() || $proyecto->usuarios->contains($usuario->id);
    }

    public function create(Usuario $usuario)
    {
        return $usuario->esAdministrador() || $usuario->tieneRol('Responsable de proyecto');
    }

    public function update(Usuario $usuario, Proyecto $proyecto)
    {
        return $usuario->esAdministrador() || 
               ($usuario->tieneRol('Responsable de proyecto') && $proyecto->usuarios->contains($usuario->id));
    }

    public function delete(Usuario $usuario, Proyecto $proyecto)
    {
        return $usuario->esAdministrador();
    }
}