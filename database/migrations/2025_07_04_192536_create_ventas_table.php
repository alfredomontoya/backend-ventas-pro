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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('fecha_venta');
            $table->decimal('total', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->enum('tipo_pago', ['efectivo', 'transferencia', 'qr']);
            $table->enum('moneda', ['BOB', 'USD']);
            $table->decimal('tipo_cambio', 10, 2)->nullable();
            $table->decimal('monto_pagado', 10, 2);
            $table->decimal('monto_pagado_usd', 10, 2)->nullable();
            $table->decimal('cambio', 10, 2)->default(0);
            $table->enum('estado', ['pagada', 'pendiente', 'anulada'])->default('pagada');
            $table->text('observaciones')->nullable();
            $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
