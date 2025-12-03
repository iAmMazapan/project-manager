<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory;
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';

    // Definir los nombres personalizados para los timestamps
    const CREATED_AT = 'fecha_creacion'; 
    const UPDATED_AT = 'fecha_actualizacion';
    
    protected $fillable = [
        'nombre_completo',
        'email',
        'contraseña',
        'telefono',
        'estado',
        'es_administrador',
    ];

    protected $hidden = [
        'contraseña',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuarios_roles', 'usuario_id', 'rol_id');
    }

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'proyectos_usuarios', 'usuario_id', 'proyecto_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'usuario_id');
    }

    public function logs()
    {
        return $this->hasMany(LogActividad::class, 'usuario_id');
    }

    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    public function tieneRol($rolNombre)
    {
        return $this->roles()->where('nombre', $rolNombre)->exists();
    }

    public function esAdministrador()
    {
        return $this->es_administrador;
    }
}