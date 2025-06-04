<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeStepController;
use App\Http\Controllers\RecipeNutritionController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\RecipeToolController;
use App\Http\Controllers\RecookController;

Route::middleware(['role:creator'])->prefix('creator')->group(function () {
    // Route::apiResource('recipes', RecipeController::class)->only([
    //     'index',
    //     'show',
    //     'store',
    //     'update',
    //     'destroy'
    // ]);
    // Route::apiResource('recipes/{id}/steps', RecipeStepController::class)->only([
    //     'index',
    //     'store',
    //     'show',
    //     'update',
    //     'destroy'
    // ]);
    // Route::apiResource('recipes/{id}/nutritions', RecipeNutritionController::class)->only([
    //     'index',
    //     'store',
    //     'show',
    //     'update',
    //     'destroy'
    // ]);
    // Route::apiResource('recipes/{id}/ingredients', RecipeIngredientController::class)->only([
    //     'index',
    //     'store',
    //     'show',
    //     'update',
    //     'destroy'
    // ]);
    // Route::apiResource('recipes/{id}/tools', RecipeToolController::class)->only([
    //     'index',
    //     'store',
    //     'show',
    //     'update',
    //     'destroy'
    // ]);

    // Route::apiResource('recooks', RecookController::class)->only([
    //     'index',
    //     'show',
    // ]);

    //recipe
    Route::get('/recipes', [RecipeController::class, 'index']);
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
});
