<?php

namespace Database\Factories;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

class RolFactory extends Factory
{
    protected $model = Rol::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->randomElement([
                'administrador', 'editor', 'visualizador', 'colaborador'
            ]),
            'descripcion' => $this->faker->sentence(),
        ];
    }

    public function administrador()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre' => 'administrador',
                'descripcion' => 'Rol con permisos completos del sistema',
            ];
        });
    }

    public function editor()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre' => 'editor',
                'descripcion' => 'Puede crear y editar proyectos y tareas',
            ];
        });
    }

    public function visualizador()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre' => 'visualizador',
                'descripcion' => 'Solo puede ver proyectos y tareas asignados',
            ];
        });
    }
}