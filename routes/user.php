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

    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/filters', [RecipeController::class, 'filter']);
    Route::get('/recipes/{id}', [RecipeController::class, 'show']);


    Route::get('/recipes/{recipe_id}/steps', [RecipeStepController::class, 'index']);
    Route::get('/recipes/{recipe_id}/steps/{step_id}', [RecipeStepController::class, 'show']);

    Route::get('/recipes/{recipe_id}/nutritions', [RecipeNutritionController::class, 'index']);
    Route::get('/recipes/{recipe_id}/nutritions/{id}', [RecipeNutritionController::class, 'show']);

    Route::get('/recipes/{recipe_id}/ingredients', [RecipeIngredientController::class, 'index']);
    Route::get('/recipes/{recipe_id}/ingredients/{id}', [RecipeIngredientController::class, 'show']);

    Route::get('/recipes/{recipe_id}/tools', [RecipeToolController::class, 'index']);
    Route::get('/recipes/{recipe_id}/tools/{id}', [RecipeToolController::class, 'show']);

    Route::get('/recipes/{recipe_id}/recooks', [RecookController::class, 'index']);
    Route::get('/recipes/{recipe_id}/recooks/{id}', [RecookController::class, 'show']);
    Route::post('/recipes/{recipe_id}/recooks', [RecookController::class, 'store']);
    Route::delete('/recipes/{recipe_id}/recooks/{id}', [RecookController::class, 'destroy']);

    Route::get('favorites', [FavoriteController::class, 'index']);
    Route::post('recipes/{recipe_id}/favorites', [FavoriteController::class, 'store']);
    Route::delete('recipes/{recipe_id}/favorites', [FavoriteController::class, 'destroy']);
    Route::post('favorites/check', [FavoriteController::class, 'check']);

    // Comments Routes
    Route::get('/recipes/{recipe_id}/comments', [RecipeController::class, 'comments']);
    Route::post('/recipes/{recipe_id}/comments', [RecipeController::class, 'addComment']);
    Route::put('/recipes/{recipe_id}/comments/{comment_id}', [RecipeController::class, 'updateComment']);
    Route::delete('/recipes/{recipe_id}/comments/{comment_id}', [RecipeController::class, 'deleteComment']);
});
