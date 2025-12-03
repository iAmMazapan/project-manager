<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'proyectos_usuarios', 'proyecto_id', 'usuario_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'proyecto_id');
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'entidad', 'tipo_entidad', 'entidad_id')
            ->where('tipo_entidad', 'proyecto');
    }
}