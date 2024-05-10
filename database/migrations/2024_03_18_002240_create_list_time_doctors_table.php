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
        Schema::create('listTimeDoctors', function (Blueprint $table) {
            $table->string('id', 200)->unique()->primary();
            $table->index('id', 'idxListTimeDoctorId');
            $table->string('timeStart')->notNull();
            $table->string('timeEnd')->notNull();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_time_doctor');
    }
};
