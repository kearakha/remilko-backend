<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeStepController;
use App\Http\Controllers\RecipeNutritionController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\RecipeToolController;
use App\Http\Controllers\RecookController;
use App\Http\Controllers\FavoriteController;

Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);

Route::get('/recipes/{recipe_id}/steps', [RecipeStepController::class, 'index']);
Route::get('/recipes/{recipe_id}/steps/{step_id}', [RecipeStepController::class, 'show']);

Route::get('/recipes/{recipe_id}/nutritions', [RecipeNutritionController::class, 'index']);
Route::get('/recipes/{recipe_id}/nutritions/{id}', [RecipeNutritionController::class, 'show']);

Route::get('/recipes/{recipe_id}/ingredients', [RecipeIngredientController::class, 'index']);
Route::get('/recipes/{recipe_id}/ingredients/{id}', [RecipeIngredientController::class, 'show']);

Route::get('/recipes/{recipe_id}/tools', [RecipeToolController::class, 'index']);
Route::get('/recipes/{recipe_id}/tools/{id}', [RecipeToolController::class, 'show']);

Route::get('/recooks', [RecookController::class, 'index']);
Route::get('/recooks/{id}', [RecookController::class, 'show']);
Route::post('/recooks', [RecookController::class, 'store']);
Route::delete('/recooks/{id}', [RecookController::class, 'destroy']);

Route::get('/favorites', [FavoriteController::class, 'index']);
Route::post('/favorites', [FavoriteController::class, 'store']);
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
Route::get('/favorites/check', [FavoriteController::class, 'check']);
