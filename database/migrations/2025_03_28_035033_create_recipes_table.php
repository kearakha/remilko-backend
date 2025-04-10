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
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->float('rating')->default(0);
            $table->integer('price_estimate')->nullable();
            $table->integer('cook_time')->nullable();
            $table->string('portion_size')->nullable();
            $table->enum('category', ['Hemat', 'Tanpa Kompor', 'Cepat Saji'])->default('Hemat')->nullable();
            $table->enum('label', ['Tanpa Babi', 'Halal', 'Vegetarian', 'Vegan', 'Gluten-Free', 'None'])->default('none');
            $table->text('photo')->nullable();
            $table->text('url_video')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
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
