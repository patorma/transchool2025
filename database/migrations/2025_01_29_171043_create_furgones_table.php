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
        Schema::create('furgones', function (Blueprint $table) {
            $table->id();
            $table->string('patente')->unique();
            $table->text('descripcion');
            $table->foreignId('usuario_transportista_id')->unique();
            $table->timestamps();

            $table->foreign('usuario_transportista_id')
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
        Schema::dropIfExists('furgones');
    }
};
