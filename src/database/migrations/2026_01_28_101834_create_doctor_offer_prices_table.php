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
        Schema::create('doctor_offer_prices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("offer_id");

            $table->decimal("price", 12, 2);
            $table->decimal("discount", 12, 2)->nullable();
            $table->string("discount_condition")->nullable();
            $table->string("free_condition")->nullable();

            $table->dateTime("published_at")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_offer_prices');
    }
};
