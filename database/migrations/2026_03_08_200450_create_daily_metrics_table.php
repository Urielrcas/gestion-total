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
    Schema::create('daily_metrics', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Conecta con el dueño de la tienda
        $table->date('date');
        $table->decimal('income', 12, 2)->default(0); // Ingresos
        $table->decimal('expenses', 12, 2)->default(0); // Gastos
        $table->integer('low_stock_alerts')->default(0); // Alertas de inventario
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_metrics');
    }
};
