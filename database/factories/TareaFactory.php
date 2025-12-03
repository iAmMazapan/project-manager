<?php

namespace Database\Factories;

use App\Models\Tarea;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class TareaFactory extends Factory
{
    /**
     * El modelo asociado a la fábrica.
     *
     * @var string
     */
    protected $model = Tarea::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Columnas que pertenecen a la tabla 'tareas'
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(),
            'estado' => $this->faker->randomElement(['por hacer', 'en progreso', 'completada']),
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_fin' => now()->addDays(10)->format('Y-m-d'),

            // Claves foráneas para las relaciones
            'proyecto_id' => Proyecto::factory(),
            'usuario_id' => Usuario::factory(),
        ];
    }
}