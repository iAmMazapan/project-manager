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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('ruta_archivo');
            $table->enum('tipo_archivo', ['pdf', 'doc', 'docx', 'jpg']);
            $table->integer('entidad_id');
            $table->enum('tipo_entidad', ['proyecto', 'tarea']);
            $table->timestamp('fecha_subida')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
