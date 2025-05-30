<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeStepController;
use App\Http\Controllers\RecipeNutritionController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\RecipeToolController;
use App\Http\Controllers\RecookController;

Route::middleware(['role:creator'])->prefix('creator')->group(function () {
    Route::apiResource('recipes', RecipeController::class)->only([
        'index',
        'show',
        'store',
        'update',
        'destroy'
    ]);
    Route::apiResource('recipes/{id}/steps', RecipeStepController::class)->only([
        'index',
        'store',
        'show',
        'update',
        'destroy'
    ]);
    Route::apiResource('recipes/{id}/nutritions', RecipeNutritionController::class)->only([
        'index',
        'store',
        'show',
        'update',
        'destroy'
    ]);
    Route::apiResource('recipes/{id}/ingredients', RecipeIngredientController::class)->only([
        'index',
        'store',
        'show',
        'update',
        'destroy'
    ]);
    Route::apiResource('recipes/{id}/tools', RecipeToolController::class)->only([
        'index',
        'store',
        'show',
        'update',
        'destroy'
    ]);

    Route::apiResource('recooks', RecookController::class)->only([
        'index',
        'show',
    ]);
});
