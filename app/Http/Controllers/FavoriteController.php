<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\Favorite;
use App\Models\Recipe;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = JWTAuth::user();
        $favorites = Favorite::with('recipe')->where('user_id', $user->id)->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Favorites retrieved successfully',
            'favorites' => $favorites,
        ]);
    }

    public function store(Request $request, $recipe_id)
    {
        $user = JWTAuth::user();

        $recipe = Recipe::findOrFail($recipe_id);

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe,
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Recipe added to favorites successfully',
            'favorite' => $favorite,
        ]);
    }

    public function destroy($id)
    {
        $user = JWTAuth::user();
        $favorite = Favorite::where('user_id', $user->id)->where('id', $id)->first();

        if (!$favorite) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Favorite not found',
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Favorite deleted successfully',
        ]);
    }

    public function check(Request $request)
    {
        $user = JWTAuth::user();
        $exists = Favorite::where('user_id', $user->id)
            ->where('recipe_id', $request->recipe_id)
            ->exists();

        return response()->json(['favorited' => $exists]);
    }
}
