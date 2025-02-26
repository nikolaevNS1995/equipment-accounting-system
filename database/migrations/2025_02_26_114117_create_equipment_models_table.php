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
        Schema::create('equipment_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_brand_id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_brand_id')->references('id')->on('equipment_brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_models');
    }
};
