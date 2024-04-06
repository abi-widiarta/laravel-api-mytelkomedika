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
            $table->id();
            $table->string('username',15);
            $table->string('name',50);
            $table->string('email',50)->unique();
            $table->string('password');
            $table->string('student_id',10);
            $table->string('phone',13)->nullable();
            $table->string('address',50)->nullable();
            $table->char('gender',1)->nullable();
            $table->date('birthdate')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
