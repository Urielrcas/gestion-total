<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID único para el usuario
            $table->string('name'); // Nombre de "Doña Mari"
            $table->string('store_name'); // Nombre de "Abarrotes La Esperanza"
            $table->string('email')->unique(); // Correo para el login
            $table->string('password'); // Contraseña encriptada
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            
            // Definición de roles (admin o cliente)
            $table->enum('role', ['admin', 'cliente'])->default('cliente');
            
            $table->rememberToken();
            $table->timestamps(); // Crea created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};