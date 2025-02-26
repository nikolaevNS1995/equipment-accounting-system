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
        Schema::create('equipment_brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_type_id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_type_id')->references('id')->on('equipment_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_brands');
    }
};
