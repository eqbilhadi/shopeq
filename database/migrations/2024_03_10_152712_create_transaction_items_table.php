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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')->cascadeOnDelete();
            
            $table->enum('status', ['IN', 'OUT']);
            $table->uuid('reff_id')->nullable();

            $table->uuid('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('mst_products')->onDelete('set null');
            
            $table->unsignedBigInteger('unit_product_id')->unsigned()->nullable();
            $table->foreign('unit_product_id')->references('id')->on('mst_unit_products')->onDelete('set null');
            
            $table->integer('qty');
            $table->float('final_qty');
            $table->float('price');
            $table->float('total_price');
            $table->date('expired')->nullable();
            $table->text('note');
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
        Schema::dropIfExists('transaction_items');
    }
};
