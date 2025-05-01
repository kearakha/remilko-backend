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
    Route::apiResource('recipes', RecipeController::class)->only([
        'index',
        'store',
        'show',
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
});
