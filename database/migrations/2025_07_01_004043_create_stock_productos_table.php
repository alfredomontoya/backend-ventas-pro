<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_productos', function (Blueprint $table) {
            $table->id();
             $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad'); // positivo = entrada, negativo = salida
            $table->string('tipo_movimiento');
            $table->timestamp('fecha_movimiento')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('nota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_productos');
    }
};
