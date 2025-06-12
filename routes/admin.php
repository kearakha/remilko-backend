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
    Route::get('stats', [AdminController::class, 'stats']);

    // Verifikasi Recook
    Route::get('recooks-verifications', [AdminController::class, 'getRecookVerifications']);
    Route::post('recooks/{id}/approve', [AdminController::class, 'approveRecook']);
    Route::post('recooks/{id}/reject', [AdminController::class, 'rejectRecook']);

    // Daftar Creator
    Route::get('creator-invitations', [AdminController::class, 'indexCreators']);
    Route::post('creator-invitations/invite', [AdminController::class, 'inviteCreator']);
    Route::put('creator-invitations/{user}/accepted', [AdminController::class, 'acceptCreatorInvitation']);
    Route::put('creator-invitations/{user}/rejected', [AdminController::class, 'rejectCreatorInvitation']);

    // Rekomendasi Resep
    Route::get('recipes-recommendations', [AdminController::class, 'getRecommendationStatus']);
    Route::put('recipes/{id}/recommendations', [AdminController::class, 'toggleRecommendation']);

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
