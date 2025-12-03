<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActividad extends Model
{
    protected $table = 'logs_actividad';
    
    const CREATED_AT = 'fecha_accion';
    const UPDATED_AT = null;
    
    protected $fillable = [
        'usuario_id',
        'tipo_accion',
        'entidad_afectada',
        'entidad_id',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}