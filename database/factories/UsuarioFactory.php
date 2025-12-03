<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {
        return [
            'nombre_completo' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'contraseña' => Hash::make('password123'),
            'telefono' => $this->faker->phoneNumber(),
            'estado' => true,
            'es_administrador' => false,
        ];
    }

    public function administrador()
    {
        return $this->state(function (array $attributes) {
            return [
                'es_administrador' => true,
            ];
        });
    }

    public function inactivo()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => false,
            ];
        });
    }
}