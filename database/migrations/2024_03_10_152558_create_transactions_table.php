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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('transaction_date');
            $table->enum('status', ['IN', 'OUT']);
            $table->enum('type', ['TRANSACTION', 'OPNAME', 'RETUR'])->default('TRANSACTION');

            $table->uuid('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('mst_suppliers')->onDelete('set null');
            
            $table->uuid('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('mst_customers')->onDelete('set null');

            $table->float('paid');
            $table->float('change')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_draft')->default(true);
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
        Schema::dropIfExists('transactions');
    }
};
