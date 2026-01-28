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
        Schema::create('doctor_offers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("service_id");
            $table->unsignedBigInteger("clinic_id");
            $table->unsignedBigInteger("department_id");

            $table->dateTime("oms")->nullable();
            $table->dateTime("appointment")->nullable();
            $table->dateTime("children")->nullable();
            $table->dateTime("adult")->nullable();
            $table->dateTime("house_call")->nullable();
            $table->dateTime("telemedicine")->nullable();
            $table->dateTime("is_base_service")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_offers');
    }
};
