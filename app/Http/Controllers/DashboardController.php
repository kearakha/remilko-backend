<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Http\Resources\RecipeResource;
use App\Http\Resources\RecookResource;
use App\Models\Recook;

class DashboardController extends Controller
{
    public function index()
    {
        $trendingRecipes = Recipe::orderBy('rating', 'desc')
            ->take(5)
            ->get();
        $exploreRecipes = Recipe::inRandomOrder()
            ->take(5)
            ->get();
        $recommendedRecipes = Recipe::where('is_recommended', true)->take(5)->get();
        $creatorRecipes = Recipe::whereHas('user', function ($q) {
            $q->where('role', 'creator');
        })->take(3)->get();
        $latestRecooks = Recook::where('status', 'Diterima')->latest()->take(5)->get();

        return response()->json([
            'data' => [
                'trending' => RecipeResource::collection($trendingRecipes),
                'explore' => RecipeResource::collection($exploreRecipes),
                'recommended' => RecipeResource::collection($recommendedRecipes),
                'creator_recipes' => RecipeResource::collection($creatorRecipes),
                'recook_results' => RecookResource::collection($latestRecooks),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Berhasil mengambil data untuk dashboard',
            ]
        ]);
    }
}
