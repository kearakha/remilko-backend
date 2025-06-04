<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeStepController;
use App\Http\Controllers\RecipeNutritionController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\RecipeToolController;
use App\Http\Controllers\RecookController;

Route::middleware(['role:creator'])->prefix('creator')->group(function () {
    //recipe
    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/filters', [RecipeController::class, 'filter']);
    Route::get('/recipes/{recipe_id}', [RecipeController::class, 'show']);
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes/{recipe_id}', [RecipeController::class, 'update']);
    Route::delete('/recipes/{recipe_id}', [RecipeController::class, 'destroy']);

    // Recipe Steps Routes
    Route::get('/recipes/{recipe_id}/steps', [RecipeStepController::class, 'index']);
    Route::post('/recipes/{recipe_id}/steps', [RecipeStepController::class, 'store']);
    Route::get('/recipes/{recipe_id}/steps/{step_id}', [RecipeStepController::class, 'show']);
    Route::put('/recipes/{recipe_id}/steps/{step_id}', [RecipeStepController::class, 'update']);
    Route::delete('/recipes/{recipe_id}/steps/{step_id}', [RecipeStepController::class, 'destroy']);

    //Recipe Nutrition Routes
    Route::get('/recipes/{recipe_id}/nutritions', [RecipeNutritionController::class, 'index']);
    Route::post('/recipes/{recipe_id}/nutritions', [RecipeNutritionController::class, 'store']);
    Route::get('/recipes/{recipe_id}/nutritions/{id}', [RecipeNutritionController::class, 'show']);
    Route::put('/recipes/{recipe_id}/nutritions/{id}', [RecipeNutritionController::class, 'update']);
    Route::delete('/recipes/{recipe_id}/nutritions/{id}', [RecipeNutritionController::class, 'destroy']);

    //Recipe Ingredients Routes
    Route::get('/recipes/{recipe_id}/ingredients', [RecipeIngredientController::class, 'index']);
    Route::post('/recipes/{recipe_id}/ingredients', [RecipeIngredientController::class, 'store']);
    Route::get('/recipes/{recipe_id}/ingredients/{id}', [RecipeIngredientController::class, 'show']);
    Route::put('/recipes/{recipe_id}/ingredients/{id}', [RecipeIngredientController::class, 'update']);
    Route::delete('/recipes/{recipe_id}/ingredients/{id}', [RecipeIngredientController::class, 'destroy']);

    //Recipe Tools Routes
    Route::get('/recipes/{recipe_id}/tools', [RecipeToolController::class, 'index']);
    Route::post('/recipes/{recipe_id}/tools', [RecipeToolController::class, 'store']);
    Route::get('/recipes/{recipe_id}/tools/{id}', [RecipeToolController::class, 'show']);
    Route::put('/recipes/{recipe_id}/tools/{id}', [RecipeToolController::class, 'update']);
    Route::delete('/recipes/{recipe_id}/tools/{id}', [RecipeToolController::class, 'destroy']);

    Route::get('/recipes/{recipe_id}/recooks', [RecookController::class, 'index']);
    Route::get('recipes/{recipe_id}/recooks/{id}', [RecookController::class, 'show']);

    // Comments Routes
    Route::get('/recipes/{recipe_id}/comments', [RecipeController::class, 'comments']);
    Route::post('/recipes/{recipe_id}/comments', [RecipeController::class, 'addComment']);
});
