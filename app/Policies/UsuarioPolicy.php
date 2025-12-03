<?php

namespace App\Policies;

use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsuarioPolicy
{
    use HandlesAuthorization;

    public function viewAny(Usuario $usuario)
    {
        return $usuario->esAdministrador();
    }

    public function view(Usuario $usuario, Usuario $model)
    {
        return $usuario->esAdministrador() || $usuario->id === $model->id;
    }

    public function create(Usuario $usuario)
    {
        return $usuario->esAdministrador();
    }

    public function update(Usuario $usuario, Usuario $model)
    {
        return $usuario->esAdministrador() || $usuario->id === $model->id;
    }

    public function delete(Usuario $usuario, Usuario $model)
    {
        return $usuario->esAdministrador() && $usuario->id !== $model->id;
    }
}