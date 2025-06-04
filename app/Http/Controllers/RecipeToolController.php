<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeToolResource;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeTool;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecipeToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($recipe_id)
    {
        $recipe = Recipe::findOrFail($recipe_id);
        $tools = RecipeTool::where('recipe_id', $recipe->id)->get();

        return response()->json([
            'data' => [
                'tools' => RecipeToolResource::collection($tools),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List of tools',
            ]
        ], 200);
    }

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
            'id' => Str::random(8),
            'recipe_id' => $recipe->id,
            'tool_name' => $validated['tool_name'],
        ]);

        return response()->json([
            'data' => [
                'tools' => new RecipeToolResource($tool),
            ],
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Tool created successfully',
            ]
        ], 201);
    }

    public function show($recipe_id, $id)
    {
        $tool = RecipeTool::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json([
            'data' => [
                'tools' => new RecipeToolResource($tool),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Tool detail retrieved successfully',
            ]
        ], 200);
    }

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

        return response()->json([
            'data' => [
                'tools' => new RecipeToolResource($tool),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Tool updated successfully',
            ]
        ], 200);
    }

    public function destroy($recipe_id, $id)
    {
        $tool = RecipeTool::where('recipe_id', $recipe_id)->findOrFail($id);
        $tool->delete();

        return response()->json([
            'data' => null,
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Tool deleted successfully',
            ]
        ], 200);
    }
}
