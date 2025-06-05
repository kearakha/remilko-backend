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
        Schema::create('recipes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->float('rating')->default(0);
            $table->integer('price_estimate')->nullable();
            $table->integer('cook_time')->nullable();
            $table->string('portion_size')->nullable();
            $table->enum('label', ['Tanpa Babi', 'Halal', 'Vegetarian', 'Vegan', 'Gluten-Free', 'None'])->default('none');
            $table->text('photo')->nullable();
            $table->text('url_video')->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();

            //foreign
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
