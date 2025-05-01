<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeStepController;
use App\Http\Controllers\RecipeNutritionController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\RecipeToolController;
use App\Http\Controllers\RecookController;
use App\Http\Controllers\FavoriteController;

Route::middleware(['role:user'])->prefix('user')->group(function () {
    Route::apiResource('recipes', RecipeController::class)->only([
        'index',
        'show',
    ]);
    Route::apiResource('recipes/{id}/steps', RecipeStepController::class)->only([
        'index',
        'show',
    ]);
    Route::apiResource('recipes/{id}/nutritions', RecipeNutritionController::class)->only([
        'index',
        'show',
    ]);
    Route::apiResource('recipes/{id}/ingredients', RecipeIngredientController::class)->only([
        'index',
        'show',
    ]);
    Route::apiResource('recipes/{id}/tools', RecipeToolController::class)->only([
        'index',
        'show',
    ]);
    Route::apiResource('recipes/{id}/recooks', RecookController::class)->only([
        'index',
        'show',
        'store',
        'update',
        'destroy',
    ]);
    Route::get('favorites', [FavoriteController::class, 'index']);
    Route::post('recipes/{id}/favorites', [FavoriteController::class, 'store']);
    Route::delete('recipes/{id}/favorites', [FavoriteController::class, 'destroy']);
    Route::post('favorites/check', [FavoriteController::class, 'check']);
});
