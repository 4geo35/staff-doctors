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
        Schema::create('offer_request_records', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("employee_request_id");
            $table->unsignedBigInteger("offer_id")->nullable();

            $table->string("clinic_title")->nullable();
            $table->string("service_title")->nullable();
            $table->string("department_title")->nullable();

            $table->decimal("price", 12, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_request_records');
    }
};
