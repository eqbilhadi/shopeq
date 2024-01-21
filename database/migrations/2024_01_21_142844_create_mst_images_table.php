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
        Schema::create('mst_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('source')->nullable();
            $table->boolean('is_main_image')->default(true);
            $table->uuidMorphs('imageable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_images');
    }
};
