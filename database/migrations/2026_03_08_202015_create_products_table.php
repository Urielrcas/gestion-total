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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Dueño del producto
        $table->string('name');
        $table->string('category');
        $table->string('code')->unique();
        $table->integer('stock')->default(0);
        $table->decimal('cost_price', 12, 2); // Precio al que compras
        $table->decimal('sell_price', 12, 2); // Precio al que vendes
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
