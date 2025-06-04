<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecipeIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($recipe_id)
    {
        $recipe = Recipe::findOrFail($recipe_id);

        return response()->json([
            'recipe_id' => $recipe->id,
            'ingredients' => $recipe->recipeIngredient,
            200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $recipe_id)
    {
        $recipe = Recipe::findOrFail($recipe_id);

        $validator = Validator::make($request->all(), [
            'ingredient_name' => 'required|string|max:255',
            'ingredient_amount' => 'required|numeric',
            'ingredient_unit' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $ingredient = RecipeIngredient::create([
            'id' => Str::random(8),
            'recipe_id' => $recipe->id,
            'ingredient_name' => $validated['ingredient_name'],
            'ingredient_amount' => $validated['ingredient_amount'],
            'ingredient_unit' => $validated['ingredient_unit'],
        ]);

        return response()->json($ingredient, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($recipe_id, $id)
    {
        $ingredient = RecipeIngredient::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json($ingredient, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $recipe_id, $id)
    {
        $ingredient = RecipeIngredient::where('recipe_id', $recipe_id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ingredient_name' => 'sometimes|required|string|max:255',
            'ingredient_value' => 'sometimes|required|numeric',
            'ingredient_unit' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $ingredient->update($validated);

        return response()->json($ingredient, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($recipe_id, $id)
    {
        RecipeIngredient::where('recipe_id', $recipe_id)->findOrFail($id)->delete();

        return response()->json([
            'message' => 'Ingredient deleted',
            'status' => 200
        ]);
    }
}
