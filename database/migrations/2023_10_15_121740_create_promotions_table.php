<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('type', 25);
            $table->string('details', 190)->nullable();
            $table->unsignedFloat('amount');
            $table->unsignedFloat('max_discount_amount')->nullable();
            $table->unsignedFloat('min_cart_amount');
            $table->string('applied_on', 30)->nullable();
            $table->json('product_info')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
