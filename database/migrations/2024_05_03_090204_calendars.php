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
            $table->increments('id');
            $table->string('doctorId', 200)->notNull();
            $table->string('timeId', 200)->notNull();
            $table->foreign('doctorId')->references('id')->on('doctors');
            $table->foreign('timeId')->references('id')->on('listTimeDoctors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};