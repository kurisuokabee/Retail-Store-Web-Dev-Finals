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
            $table->id('order_id'); // INT AUTO_INCREMENT

            $table->unsignedBigInteger('customer_id');
            $table->timestamp('order_date')->useCurrent();

            $table->enum('order_status', ['pending', 'processing', 'completed', 'cancelled']);
            $table->decimal('total_amount', 12, 2);

            $table->enum('payment_status', ['pending', 'paid', 'failed']);
            $table->string('payment_method', 50);

            $table->text('shipping_address');

            // timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign key
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
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
