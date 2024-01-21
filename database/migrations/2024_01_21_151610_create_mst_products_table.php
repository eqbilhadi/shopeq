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
        Schema::create('mst_products', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('mst_category')->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('barcode')->nullable();
            $table->double('selling_price')->nullable();
            $table->double('purchase_price')->nullable();
            $table->double('minimal_stok')->nullable();

            $table->timestamps();
            $table->uuid('created_by');
            $table->uuid('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_products');
    }
};
