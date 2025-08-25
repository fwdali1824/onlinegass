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
        Schema::create('orders_issues', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->enum('type', ['wrong_delivery', 'damaged_cylinder', 'missing_item', 'other']);
            $table->text('description')->nullable();
            $table->boolean('resolved')->default(false);
            $table->string('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_issues');
    }
};
