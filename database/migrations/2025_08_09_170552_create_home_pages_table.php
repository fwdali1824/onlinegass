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
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page')->nullable();
            $table->string('section')->nullable();
            $table->string('title')->nullable();
            $table->string('heading')->nullable();
            $table->string('content')->nullable();
            $table->string('points')->nullable();
            $table->string('images')->nullable();
            $table->string('link')->nullable();
            $table->string('button1')->nullable();
            $table->string('buttonLink1')->nullable();
            $table->string('button2')->nullable();
            $table->string('buttonLink2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
