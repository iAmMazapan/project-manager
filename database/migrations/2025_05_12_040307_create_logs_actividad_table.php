<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs_actividad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->enum('tipo_accion', ['crear', 'editar', 'eliminar']);
            $table->enum('entidad_afectada', ['proyecto', 'tarea', 'usuario']);
            $table->integer('entidad_id');
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_accion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_actividad');
    }
};
