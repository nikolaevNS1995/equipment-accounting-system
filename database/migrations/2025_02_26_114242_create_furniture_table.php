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
        Schema::create('furniture', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('furniture_type_id');
            $table->unsignedBigInteger('cabinet_id')->nullable();
            $table->unsignedBigInteger('inventory_number');
            $table->timestamps();
            $table->softDeletes();

            $table->index('cabinet_id');

            $table->foreign('furniture_type_id')->references('id')->on('furniture_types')->onDelete('cascade');
            $table->foreign('cabinet_id')->references('id')->on('cabinets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furniture');
    }
};
