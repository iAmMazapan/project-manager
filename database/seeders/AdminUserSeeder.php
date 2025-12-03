<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $admin = Usuario::create([
            'nombre_completo' => 'Administrador',
            'email' => 'admin@admin.com',
            'contraseña' => Hash::make('admin123'),
            'telefono' => '123456789',
            'estado' => true,
            'es_administrador' => true,
        ]);

        // Asignar el rol de administrador
        $rolAdmin = Rol::where('nombre', 'Administrador del sistema')->first();
        if ($rolAdmin) {
            $admin->roles()->attach($rolAdmin->id);
        }
    }
}