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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('nro');
            $table->date('fecha');
            $table->string('ci', 20);
            $table->string('nombre', 128);
            $table->string('referencia')->nullable();
            $table->string('uv')->nullable();
            $table->string('mz')->nullable();
            $table->string('lt')->nullable();
            $table->string('diamante')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // usuario que registró
            $table->timestamps();

            $table->unique(['nro', 'fecha']); // opcional, puedes usar ['nro', 'gestion'] si separas el año
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
