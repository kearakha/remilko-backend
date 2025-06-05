<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeStepResource;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeStep;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecipeStepController extends Controller
{
    public function index($recipe_id)
    {
        //error
        $recipe = Recipe::findOrFail($recipe_id);
        $steps = RecipeStep::where('recipe_id', $recipe->id)->get();

        return response()->json([
            'data' => [
                'steps' => RecipeStepResource::collection($steps),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List of steps',
            ]
        ]);
    }


    public function store(Request $request, $recipe_id)
    {
        $recipe = Recipe::findOrFail($recipe_id);

        $validator = Validator::make($request->all(), [
            'step_number' => 'required|integer',
            'step_description' => 'required|string',
            'photo_step' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo_step')) {
            $file = $request->file('photo_step');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/recipe/step'), $filename);
            $validated['photo_step'] = $filename;
        }

        $steps = RecipeStep::create([
            'id' => Str::random(8),
            'recipe_id' => $recipe->id,
            'step_number' => $validated['step_number'],
            'step_description' => $validated['step_description'],
            'photo_step' => $validated['photo_step'] ?? null,
        ]);

        return response()->json([
            'data' => [
                'step' => new RecipeStepResource($steps),
            ],
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Step created successfully',
            ]
        ], 201);
    }

    public function show($recipe_id, $id)
    {
        $steps = RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json([
            'data' => [
                'step' => new RecipeStepResource($steps),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Step detail retrieved successfully',
            ]
        ], 200);
    }

    public function update(Request $request, $recipe_id, $id)
    {
        $steps = RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'step_number' => 'sometimes|required|integer',
            'step_description' => 'sometimes|required|string',
            'photo_step' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo_step')) {
            $file = $request->file('photo_step');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/recipe/step'), $filename);
            $validated['photo_step'] = $filename;
        }

        $steps->update($validated);

        return response()->json([
            'data' => [
                'step' => new RecipeStepResource($steps),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Step updated successfully',
            ]
        ], 200);
    }

    public function destroy($recipe_id, $id)
    {
        $steps = RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id);
        $steps->delete();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Step deleted successfully',
            ]
        ], 200);
    }
}
