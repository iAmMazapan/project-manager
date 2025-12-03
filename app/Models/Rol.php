<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarios_roles', 'rol_id', 'usuario_id');
    }
}