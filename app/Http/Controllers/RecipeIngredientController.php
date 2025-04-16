<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeIngredient;

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
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'ingredient_name' => 'required|string|max:255',
            'ingredient_value' => 'required|numeric',
            'ingredient_unit' => 'required|string|max:255',
        ]);

        $recipe = Recipe::findOrFail($recipe_id);

        $ingredient = $recipe->recipeIngredient()->create($request->all());

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

        $request->validate([
            'ingredient_name' => 'required|string|max:255',
            'ingredient_value' => 'required|numeric',
            'ingredient_unit' => 'required|string|max:255',
        ]);

        $ingredient->update($request->all());

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
