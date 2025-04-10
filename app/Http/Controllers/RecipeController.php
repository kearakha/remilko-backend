<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function index()
    {
        $recipe = Recipe::all();
        // $recipe = Recipe::with('steps')->get();
        return response()->json($recipe, 200);
    }

    public function store(Request $request)
    {
        if (!in_array(JWTAuth::user()->role, ['admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'price_estimate' => 'nullable|integer',
            'cook_time' => 'nullable|integer',
            'portion_size' => 'nullable|string',
            'category' => 'nullable|in:Hemat,Tanpa Kompor,Cepat Saji',
            'label' => 'nullable|in:Tanpa Babi,Halal,Vegetarian,Vegan,Gluten-Free,None',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'nullable|url',
            'comment' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors()
            ], 422);
        }

        $recipe = Recipe::create($validated);

        return response()->json([
            'message' => 'Recipe created',
            'recipe' => $recipe
        ], 201);
    }

    public function show($id)
    {
        if (!in_array(JWTAuth::user()->role, ['admin', 'user'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recipe = Recipe::with('steps')->find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }

        return response()->json($recipe);
    }

    public function update(Request $request, $id)
    {
        if (!in_array(JWTAuth::user()->role, ['admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recipe not found'
            ], 404);
        }

        $validated = Validator::make($request->all(), [
            'user_id' => 'sometimes|required|exists:users,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'rating' => 'sometimes|nullable|numeric|min:0|max:5',
            'price_estimate' => 'sometimes|nullable|integer',
            'cook_time' => 'sometimes|nullable|integer',
            'portion_size' => 'sometimes|nullable|string',
            'category' => 'sometimes|nullable|in:Hemat,Tanpa Kompor,Cepat Saji',
            'label' => 'sometimes|nullable|in:Tanpa Babi,Halal,Vegetarian,Vegan,Gluten-Free,None',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'sometimes|nullable|url',
            'comment' => 'sometimes|nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validated->errors()
            ], 422);
        }

        $recipe->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $recipe
        ]);
    }

    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recipe not found'
            ], 404);
        }

        $recipe->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recipe deleted successfully'
        ]);
    }
}
