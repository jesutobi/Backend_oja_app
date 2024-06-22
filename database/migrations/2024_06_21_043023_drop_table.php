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
        Schema::table('products_image', function (Blueprint $table) {
            $table->dropForeign(['product_id']); // Drop foreign key constraint
        });
        Schema::drop('products');
        Schema::drop('products_image');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
