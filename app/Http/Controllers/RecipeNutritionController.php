<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeNutritionResource;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeNutrition;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecipeNutritionController extends Controller
{
    //blm
    public function index($recipe_id)
    {
        $recipe = Recipe::findOrfail($recipe_id);
        $nutrition = RecipeNutrition::where('recipe_id', $recipe->id)->get();

        return response()->json([
            'data' => [
                'nutrition' => RecipeNutritionResource::collection($nutrition),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List of nutrition for recipe',
            ],
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
            'nutrition_name' => 'required|string|max:255',
            'nutrition_value' => 'required|numeric',
            'nutrition_unit' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $nutrition = RecipeNutrition::create([
            'id' => Str::random(8),
            'recipe_id' => $recipe->id,
            'nutrition_name' => $validated['nutrition_name'],
            'nutrition_value' => $validated['nutrition_value'],
            'nutrition_unit' => $validated['nutrition_unit'],
        ]);

        return response()->json([
            'data' => [
                'nutrition' => new RecipeNutritionResource($nutrition),
            ],
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Nutrition created successfully',
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($recipe_id, $id)
    {
        $nutrition = RecipeNutrition::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json([
            'data' => [
                'nutrition' => new RecipeNutritionResource($nutrition),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Nutrition retrieved successfully',
            ],
            200
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $recipe_id, $id)
    {
        $nutrition = RecipeNutrition::where('recipe_id', $recipe_id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nutrition_name' => 'sometimes|required|string|max:255',
            'nutrition_value' => 'sometimes|required|numeric',
            'nutrition_unit' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $nutrition->update($validated);

        return response()->json([
            'data' => [
                'nutrition' => new RecipeNutritionResource($nutrition),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Nutrition updated successfully',
            ],
            200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($recipe_id, $id)
    {
        RecipeNutrition::where('recipe_id', $recipe_id)->findOrFail($id)->delete();
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Nutrition deleted successfully',
            ],
            200
        ]);
    }
}
