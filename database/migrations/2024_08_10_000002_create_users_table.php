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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surnames')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_image')->nullable(); // Campo para el archivo de imagen
            $table->text('description')->nullable(); // Campo para la descripción
            $table->integer('age')->nullable(); // Campo para la edad
            $table->string('phone_number')->nullable(); // Campo para el número de teléfono
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null'); // Campo para la relación con roles
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
