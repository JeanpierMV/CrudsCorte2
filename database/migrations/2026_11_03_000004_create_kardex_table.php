<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras');
            $table->foreignId('insumo_id')->constrained('insumos');
            $table->string('tipo', 20)->default('COMPRA');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('stock_anterior', 10, 2);
            $table->decimal('stock_nuevo', 10, 2);
            $table->date('fecha_movimiento');
            $table->timestamps();

            $table->index(['insumo_id', 'fecha_movimiento'], 'idx_kardex_insumo_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kardex');
    }
};
