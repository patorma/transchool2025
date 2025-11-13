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
        Schema::create('mensualidades', function (Blueprint $table) {
            $table->id();
            $table->integer('monto');
            $table->date('fecha_vencimiento');
            $table->enum('estado',['pendiente','pagado','moroso'])->default('pendiente');
            $table->boolean('enabled')->default(true);
            $table->foreignId('usuario_id');
            $table->timestamps();

            $table->foreign('usuario_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensualidades');
    }
};
