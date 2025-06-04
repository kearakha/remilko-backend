<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeStepController;
use App\Http\Controllers\RecipeNutritionController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\RecipeToolController;
use App\Http\Controllers\AdminController;

Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    // Dashboard Ringkasan
    Route::get('dashboard', [AdminController::class, 'index']);

    // Verifikasi Recook
    Route::post('recooks/{id}/approve', [AdminController::class, 'approveRecook']);
    Route::post('recooks/{id}/reject', [AdminController::class, 'rejectRecook']);

    // Aktivitas Terbaru
    Route::get('activities', [AdminController::class, 'recentActivities']);

    // Daftar Creator
    Route::post('creators/invite', [AdminController::class, 'inviteCreator']);
    Route::delete('creators/{id}', [AdminController::class, 'deleteCreator']);

    // Rekomendasi Resep
    Route::put('recipes/{id}/recommendation', [AdminController::class, 'toogleRecommendation']);

    // Daftar Resep
    // Route::apiResource('recipes', RecipeController::class)->only([
    //     'index',
    //     'store',
    //     'show',
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
});
