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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('order_status_id')->constrained('order_statuses')->onDelete('restrict');

            $table->text('shipping_address');
            $table->string('contact_phone', 20);

            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00); // Thuế (Tax Amount): (VAT/GST)
            $table->decimal('shipping_fee', 10, 2)->default(0.00); // Phí Vận chuyển (Shipping Fee)
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->string('payment_method', 255);
            $table->text('notes')->nullable();
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
