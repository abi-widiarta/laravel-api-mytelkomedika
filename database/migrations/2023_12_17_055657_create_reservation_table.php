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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->string('status')->default('approved');
            $table->string('initial_complaint')->default('');
            $table->integer('queue_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
