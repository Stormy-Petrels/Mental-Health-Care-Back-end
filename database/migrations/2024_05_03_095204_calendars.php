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
        Schema::create('calendars', function (Blueprint $table) {
            $table->string('id', 200)->unique()->primary();
            $table->string('doctorId', 200)->notNull();
            $table->string('timeId', 200)->notNull();
            $table->string('date', 200)->notNull();
            $table->string('month', 200)->notNull();
            $table->string('year', 200)->notNull();
            $table->foreign('doctorId')->references('id')->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
