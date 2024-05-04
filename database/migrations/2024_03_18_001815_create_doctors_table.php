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
        Schema::create('doctors', function (Blueprint $table) {
            $table->string('id', 200)->unique()->primary();
            $table->string('userId', 200)->notNull();
            $table->string('description', 200)->nullable();
            $table->string('majorId')
                ->nullable();
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('majorId')->references('id')->on('majors');
            $table->timestamps();
        });
    }
  
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};