<?php

namespace Database\Factories;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    public function definition()
    {
        $fechaInicio = $this->faker->dateTimeBetween('now', '+1 month');
        $fechaFin = $this->faker->dateTimeBetween($fechaInicio, '+6 months');

        return [
            'titulo' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph(),
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
        ];
    }

    public function sinFechas()
    {
        return $this->state(function (array $attributes) {
            return [
                'fecha_inicio' => null,
                'fecha_fin' => null,
            ];
        });
    }

    public function urgente()
    {
        return $this->state(function (array $attributes) {
            return [
                'titulo' => 'Proyecto Urgente - ' . $this->faker->words(3, true),
                'fecha_inicio' => now()->format('Y-m-d'),
                'fecha_fin' => now()->addDays(30)->format('Y-m-d'),
            ];
        });
    }
}