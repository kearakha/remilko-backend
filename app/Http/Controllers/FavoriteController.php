<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Support\Str;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = JWTAuth::user();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List of favorites',
            ],
            200
        ]);
    }

    public function store(Request $request, $recipe_id)
    {
        $user = JWTAuth::user();

        $recipe = Recipe::findOrFail($recipe_id);

        $favorite = Favorite::create([
            'id' => Str::random(8),
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
        ]);

        return response()->json([
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Favorite added successfully',
            ],
        ]);
    }

    public function destroy($recipe_id)
    {
        $user = JWTAuth::user();
        $favorite = Favorite::where('user_id', $user->id)->where('recipe_id', $recipe_id)->first();

        if (!$favorite) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Favorite not found',
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Favorite removed successfully',
            ],
        ]);
    }

    public function check(Request $request)
    {
        $user = JWTAuth::user();
        $exists = Favorite::where('user_id', $user->id)
            ->where('recipe_id', $request->recipe_id)
            ->exists();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Check favorite status',
            ],
            'data' => [
                'exists' => $exists,
            ],
        ]);
    }
}
