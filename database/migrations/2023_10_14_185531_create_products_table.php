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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('title_cn', 100);
            $table->string('slug', 100)->unique();
            $table->unsignedFloat('regular_price')->default(0);
            $table->unsignedFloat('sale_price')->nullable();
            $table->unsignedFloat('stock')->default(0);
            $table->longText('description')->nullable();
            $table->string('label', 50)->nullable();
            $table->string('thumbnail', 100)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
