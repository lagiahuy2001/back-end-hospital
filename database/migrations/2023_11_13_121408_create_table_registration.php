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
        Schema::create('registration', function (Blueprint $table) {
            $table->id();
            $table->string('address_appointment')->nullable();
            $table->date('date_appointment')->nullable();
            $table->time('time_appointment')->nullable();
            $table->timestamp('time_take_test')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->boolean('refuse')->nullable();
            $table->string('note')->nullable();
            $table->string('total_price')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->boolean('user_sex')->nullable();
            $table->date('user_date')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('staff_id')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
