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
        Schema::create('cabinets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cabinet_type_id');
            $table->unsignedBigInteger('building_id');
            $table->string('title');
            $table->integer('cabinet_number');
            $table->integer('floor');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cabinet_type_id')->references('id')->on('cabinet_types');
            $table->foreign('building_id')->references('id')->on('buildings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabinets');
    }
};
