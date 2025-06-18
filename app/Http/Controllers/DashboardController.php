<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeIngredientsResource;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Http\Resources\RecipeResource;
use App\Http\Resources\RecookResource;
use App\Http\Resources\UserResource;
use App\Models\Recook;
use App\Models\RecipeIngredient;
use App\Models\User;

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
        $creatorRecipes = Recipe::with('user')
            ->whereHas('user', function ($q) {
                $q->where('role', 'creator');
            })
            ->take(3)
            ->get()
            ->groupBy('user.id')
            ->map(function ($recipes) {
                $user = $recipes->first()->user;
                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'photo_user' => $user->photo_user ? asset($user->photo_user) : null,
                    'recipe_count' => $user->recipes()->count(),
                    'latest_recipe' => new RecipeResource($recipes->first()),
                ];
            })->values();
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

    public function globalSearch(Request $request)
    {
        $q = $request->input('q');

        $recipes = Recipe::where('title', 'like', "%{$q}%")->get();
        $ingredients = RecipeIngredient::where('ingredient_name', 'like', "%{$q}%")->get();
        $creators = User::where('role', 'creator')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })->get();

        return response()->json([
            'data' => [
                'recipes' => RecipeResource::collection($recipes),
                'ingredients' => RecipeIngredientsResource::collection($ingredients),
                'creators' => UserResource::collection($creators),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Hasil pencarian ditemukan'
            ]
        ]);
    }
}
