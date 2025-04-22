<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeTool;
use Illuminate\Support\Facades\Validator;

class RecipeToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($recipe_id)
    {
        $recipe = Recipe::findOrFail($recipe_id);

        return response()->json([
            'recipe_id' => $recipe->id,
            'tools' => $recipe->recipeTool,
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
            'tool_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $tool = RecipeTool::create([
            'recipe_id' => $recipe->id,
            'tool_name' => $validated['tool_name'],
        ]);

        return response()->json($tool, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($recipe_id, $id)
    {
        $tool = RecipeTool::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json($tool, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $recipe_id, $id)
    {
        $tool = RecipeTool::where('recipe_id', $recipe_id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tool_name' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $tool->update($validated);

        return response()->json($tool, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($recipe_id, $id)
    {
        RecipeTool::where('recipe_id', $recipe_id)->findOrFail($id)->delete();

        return response()->json([
            'message' => 'Tool deleted successfully'
        ], 200);
    }
}
