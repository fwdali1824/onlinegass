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
        Schema::create('referals', function (Blueprint $table) {
            $table->id();
            $table->string('referrer_id')->constrained('users')->onDelete('cascade');
            $table->string('referred_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'completed', 'invalid'])->default('pending');
            $table->decimal('referrer_bonus')->default(0);
            $table->decimal('referred_bonus')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referals');
    }
};
