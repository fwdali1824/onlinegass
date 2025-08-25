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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('image');
            $table->string('product_category');
            $table->string('weight');
            $table->string('price');
            $table->integer('stock');
            $table->boolean('is_cylinder')->default(true);
            $table->enum('cylinder_type', ['domestic', 'commercial', 'industrial'])->default('domestic');
            $table->string('cylinder_material')->nullable();
            $table->string('cylinder_capacity')->nullable();
            $table->string('cylinder_pressure')->nullable();
            $table->string('description');
            $table->string('shop');
            $table->string('p_price');
            $table->enum('status', ['active', 'discontinued'])->default('active');
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
