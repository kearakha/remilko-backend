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
        Schema::create('recooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->text('photo_recook')->nullable();
            $table->enum('difficulty', ['Mudah', 'Sedang', 'Sulit']);
            $table->enum('taste', ['Enak', 'Biasa', 'Tidak Enak']);
            $table->text('description');
            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recooks');
    }
};
