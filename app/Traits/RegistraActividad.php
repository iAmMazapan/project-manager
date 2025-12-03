<?php

namespace App\Traits;

use App\Models\LogActividad;

trait RegistraActividad
{
    public function registrarActividad($usuarioId, $tipoAccion, $entidadAfectada, $entidadId, $descripcion = null)
    {
        return LogActividad::create([
            'usuario_id' => $usuarioId,
            'tipo_accion' => $tipoAccion,
            'entidad_afectada' => $entidadAfectada,
            'entidad_id' => $entidadId,
            'descripcion' => $descripcion,
        ]);
    }
}