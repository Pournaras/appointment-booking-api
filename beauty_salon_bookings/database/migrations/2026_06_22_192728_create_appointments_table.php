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
        Schema::create('appointments', function (Blueprint $table) {
            
            $table->id(); // BIGINT UNSIGNED, PRIMARY KEY, AUTO_INCREMENT

            $table->unsignedInteger('specialist_id');
            $table->unsignedInteger('service_id');

            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->foreign('specialist_id')
                  ->references('id')
                  ->on('specialists')
                  ->onDelete('cascade');

            $table->foreign('service_id')
                  ->references('id')
                  ->on('services')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
