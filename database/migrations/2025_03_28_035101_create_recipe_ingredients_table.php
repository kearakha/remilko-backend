<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->string('ingredient_name');
            $table->integer('ingredient_amount');
            $table->string('ingredient_unit');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
