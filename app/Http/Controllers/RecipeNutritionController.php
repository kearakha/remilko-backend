<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeNutrition;

class RecipeNutritionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($recipe_id)
    {
        $recipe = Recipe::findOrfail($recipe_id);

        return response()->json([
            'recipe_id' => $recipe->id,
            'nutritions' => $recipe->recipeNutrition,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $recipe_id)
    {
        $request->validate([
            'nutrition_name' => 'required|string|max:255',
            'nutrition_value' => 'required|numeric',
            'nutrition_unit' => 'required|string|max:255',
        ]);

        $recipe = Recipe::findOrFail($recipe_id);

        $nutrition = $recipe->recipeNutrition()->create($request->all());

        return response()->json($nutrition, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($recipe_id, $id)
    {
        $nutrition = RecipeNutrition::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json($nutrition, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $recipe_id, $id)
    {
        $nutrition = RecipeNutrition::where('recipe_id', $recipe_id)->findOrFail($id);

        $request->validate([
            'nutrition_name' => 'required|string|max:255',
            'nutrition_value' => 'required|numeric',
            'nutrition_unit' => 'required|string|max:255',
        ]);

        $nutrition->update($request->all());

        return response()->json($nutrition, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($recipe_id, $id)
    {
        RecipeNutrition::where('recipe_id', $recipe_id)->findOrFail($id)->delete();
        return response()->json(['message' => 'Nutrition deleted'], 200);
    }
}
