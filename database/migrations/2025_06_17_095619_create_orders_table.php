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
            $table->string('user_id');
            $table->string('delivery_person_id');
            $table->string('quantity');
            $table->string('price');
            $table->string('p_price');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['unpaid', 'paid', 'partial'])->default('unpaid');
            $table->enum('payment_method', ['cod', 'online'])->default('cod');
            $table->enum('status', [
                'pending',
                'confirmed',
                'out_for_delivery',
                'delivered',
                'cancelled',
                'returned'
            ])->default('pending');
            $table->string('delivery_address');
            $table->string('shop')->nullable();
            $table->string('delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->text('product_id')->nullable();
            $table->text('orderid')->nullable();
            $table->text('longitude')->nullable();
            $table->text('latitude')->nullable();
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
