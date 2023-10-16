<?php

use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->index()->unique();
            $table->unsignedFloat('sub_total')->default(0);
            $table->unsignedFloat('total')->default(0);
            $table->string('status', 50)->index();
            $table->string('transaction_id', 50)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_status', 25)->nullable();
            $table->string('shipping_method', 100)->nullable();
            $table->unsignedFloat('shipping_fee')->default(0);
            $table->dateTime('delivery_time')->nullable();
            $table->string('delivery_address', 190)->nullable();
            $table->string('delivery_address_details', 190)->nullable();
            $table->string('delivery_name', 70)->nullable();
            $table->string('delivery_email', 120)->nullable();
            $table->string('delivery_phone', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
