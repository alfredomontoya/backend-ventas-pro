<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('derivacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tramite_id')->constrained()->onDelete('cascade');
            $table->foreignId('usuario_origen_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('usuario_destino_id')->constrained('users')->onDelete('cascade');
            $table->string('area', 100);
            $table->text('glosa')->nullable();
            $table->unsignedInteger('orden')->nullable();
            $table->timestamp('fecha_derivacion')->nullable();
            $table->timestamp('fecha_recepcion')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('derivacions');
    }
};
