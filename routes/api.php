<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.jwt')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

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
