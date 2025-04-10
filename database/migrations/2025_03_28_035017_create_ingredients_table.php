<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('ingredient_name')->unique(); // Nama bahan harus unik
            $table->string('photo_ingredient')->nullable(); // Foto bahan opsional
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
};
