<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::middleware('auth.jwt')->group(function () {
    Route::get('/profile', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/search', [DashboardController::class, 'globalSearch']);
    Route::get('/recipes/filters', [RecipeController::class, 'filter']);

    Route::middleware('admin')->group(function () {
        @include_once 'admin.php';
    });

    Route::middleware('creator')->group(function () {
        @include 'content_creator.php';
    });

    Route::middleware('user')->group(function () {
        @include 'user.php';
    });
});
