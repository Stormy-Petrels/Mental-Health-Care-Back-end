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
            $table->string('id', 200)->unique()->primary();
            $table->enum('role', ['admin', 'doctor', 'patient'])->notNull();
            $table->string('email', 200)->unique()->notNull();
            $table->string('password', 200)->notNull();
            $table->string('fullName', 200)->notNull();
            $table->string('phone', 20)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('urlImage', 200)->nullable();
            $table->boolean('isActive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};