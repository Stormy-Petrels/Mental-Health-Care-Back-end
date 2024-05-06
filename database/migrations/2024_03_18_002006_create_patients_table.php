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
        Schema::create('patients', function (Blueprint $table) {
            $table->string('id', 200)->unique()->primary();
            $table->string('userId', 200)->notNull();
            $table->foreign('userId')->references('id')->on('users');
            $table->string('healthCondition', 800)->default('')->nullable();
            $table->string('note', 500)->default('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};