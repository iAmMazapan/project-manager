<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'archivos';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'ruta_archivo',
        'tipo_archivo',
        'entidad_id',
        'tipo_entidad',
    ];

    public function entidad()
    {
        if ($this->tipo_entidad === 'proyecto') {
            return $this->belongsTo(Proyecto::class, 'entidad_id');
        } elseif ($this->tipo_entidad === 'tarea') {
            return $this->belongsTo(Tarea::class, 'entidad_id');
        }
        
        return null;
    }
}