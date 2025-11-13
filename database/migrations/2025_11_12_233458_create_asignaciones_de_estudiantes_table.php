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
        Schema::create('asignaciones_de_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_registro');
            $table->foreignId('estudiante_id')->unique();
            $table->foreignId('recorrido_id');
            $table->foreignId('furgon_id');

            $table->timestamps();

            $table->foreign('estudiante_id')
            ->references('id')
            ->on('estudiantes')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('recorrido_id')
            ->references('id')
            ->on('recorridos')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('furgon_id')
            ->references('id')
            ->on('furgones')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones_de_estudiantes');
    }
};
