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
        Schema::create('mst_unit_products', function (Blueprint $table) {
            $table->id();
            $table->uuidMorphs('unitable');

            $table->uuid('unit_id');
            $table->foreign('unit_id')->references('id')->on('mst_units')->cascadeOnDelete();

            $table->double('convert_main')->nullable();
            $table->double('convert_other')->nullable();
            $table->boolean('is_main_unit')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_unit_products');
    }
};
