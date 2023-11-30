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
        Schema::create('patient_transaction_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('users')->nullOnDelete();
            $table->text('message')->nullable();
            $table->text('additional_information')->nullable();
            $table->timestamps();
        });

        Schema::create('staff_transaction_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->foreign('staff_id')->references('id')->on('users')->nullOnDelete();
            $table->text('message')->nullable();
            $table->text('additional_information')->nullable();
            $table->timestamps();
        });

        Schema::create('tester_transaction_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tester_id')->nullable();
            $table->foreign('tester_id')->references('id')->on('users')->nullOnDelete();
            $table->text('message')->nullable();
            $table->text('additional_information')->nullable();
            $table->timestamps();
        });

        Schema::create('coordinator_transaction_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coordinator_id')->nullable();
            $table->foreign('coordinator_id')->references('id')->on('users')->nullOnDelete();
            $table->text('message')->nullable();
            $table->text('additional_information')->nullable();
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
