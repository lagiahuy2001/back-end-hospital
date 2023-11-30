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
        Schema::create('registration_service', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('registration_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('tester_id')->nullable();
            $table->foreign('registration_id')->references('id')->on('registration')->nullOnDelete();
            $table->foreign('service_id')->references('id')->on('service')->nullOnDelete();
            $table->foreign('tester_id')->references('id')->on('users')->nullOnDelete();
            $table->text('additional_information')->nullable();
            $table->boolean('status')->default(0);
            $table->string('patient_name')->nullable();
            $table->date('patient_date')->nullable();
            $table->boolean('patient_sex')->nullable();
            $table->string('service_name')->nullable();
            $table->text('advise')->nullable();
            $table->string('driver_test')->nullable();
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
