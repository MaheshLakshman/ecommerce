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
        Schema::create('variant_option_products', function (Blueprint $table) {

            $table->unsignedBigInteger('variant_option_id');
            $table->unsignedBigInteger('product_variant_id');

            $table->foreign('variant_option_id')
            ->references('id')
            ->on('variant_options')
            ->cascadeOnDelete();

            $table->foreign('product_variant_id')
            ->references('id')
            ->on('product_variants')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_option_products');
    }
};
