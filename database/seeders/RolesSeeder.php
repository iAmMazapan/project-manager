<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'nombre' => 'Administrador del sistema',
                'descripcion' => 'Acceso completo a todas las funcionalidades del sistema',
            ],
            [
                'nombre' => 'Responsable de proyecto',
                'descripcion' => 'Puede gestionar proyectos y sus tareas asociadas',
            ],
            [
                'nombre' => 'Responsable de tarea',
                'descripcion' => 'Puede ver y actualizar el estado de las tareas asignadas',
            ],
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}