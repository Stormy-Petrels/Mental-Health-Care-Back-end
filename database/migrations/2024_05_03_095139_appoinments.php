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
        Schema::create('appoinments', function (Blueprint $table) {
            $table->string('id', 200)->unique()->primary();
            $table->string('patientId', 200)->notNull();
            $table->string('doctorId', 200)->notNull();
            $table->date('dateBooking')->notNull();
            $table->string('calendarId', 200)->notNull();
            $table->foreign('doctorId')->references('id')->on('doctors');
            $table->foreign('patientId')->references('id')->on('patients');
            $table->foreign('calendarId')->references('id')->on('calendars');
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
