<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeStep;

class RecipeStepController extends Controller
{
    public function index($recipe_id)
    {
        $recipe = Recipe::findOrfail($recipe_id);

        return response()->json([
            'recipe_id' => $recipe->id,
            'steps' => $recipe->recipeStep,
            200
        ]);
    }

    public function store(Request $request, $recipe_id)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'step_number' => 'required|integer',
            'step_description' => 'required|string',
            'photo_step' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $recipe = Recipe::findOrFail($recipe_id);

        $step = $recipe->recipeStep()->create($request->all());

        return response()->json($step, 201);
    }

    public function show($recipe_id, $id)
    {
        $step = RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json($step, 200);
    }

    public function update(Request $request, $recipe_id, $id)
    {
        $step = RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id);

        $request->validate([
            'step_number' => 'required|integer',
            'step_description' => 'required|string',
            'photo_step' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $step->update($request->all());

        return response()->json($step, 200);
    }

    public function destroy($recipe_id, $id)
    {
        RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id)->delete();
        return response()->json(['message' => 'Step deleted'], 200);
    }
}
