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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_model_id');
            $table->unsignedBigInteger('cabinet_id')->nullable();
            $table->unsignedBigInteger('inventory_number');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('equipment_model_id')->references('id')->on('equipment_models');
            $table->foreign('cabinet_id')->references('id')->on('cabinets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
