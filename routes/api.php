<?php

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeStepController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('jwt.auth')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //recipe
    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/{id}', [RecipeController::class, 'show']);
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes/{id}', [RecipeController::class, 'update']);
    Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);

    // Recipe Steps Routes
    Route::get('/recipes/{recipe_id}/steps', [RecipeStepController::class, 'index']);
    Route::post('/recipes/{recipe_id}/steps', [RecipeStepController::class, 'store']);
    Route::get('/recipes/{recipe_id}/steps/{step_id}', [RecipeStepController::class, 'show']);
    Route::put('/recipes/{recipe_id}/steps/{step_id}', [RecipeStepController::class, 'update']);
    Route::delete('/recipes/{recipe_id}/steps/{step_id}', [RecipeStepController::class, 'destroy']);
});
