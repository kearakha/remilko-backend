<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeStep;
use Illuminate\Support\Facades\Validator;

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
            $file->move(public_path('images'), $filename);
            $validated['photo_step'] = $filename;
        }

        $step = RecipeStep::create([
            'recipe_id' => $recipe->id,
            'step_number' => $validated['step_number'],
            'step_description' => $validated['step_description'],
            'photo_step' => $validated['photo_step'],
        ]);

        return response()->json([
            'message' => 'Step created successfully',
            'recipe_id' => $recipe->id,
            'step' => $step,
        ]);
    }

    public function show($recipe_id, $id)
    {
        $step = RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json($step, 200);
    }

    public function update(Request $request, $recipe_id, $id)
    {
        $step = RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'step_number' => 'sometimes|required|integer',
            'step_description' => 'sometimes|required|string',
            'photo_step' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo_step')) {
            $file = $request->file('photo_step');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['photo_step'] = $filename;
        }

        $step->update($validated);

        return response()->json($step, 200);
    }

    public function destroy($recipe_id, $id)
    {
        RecipeStep::where('recipe_id', $recipe_id)->findOrFail($id)->delete();
        return response()->json(['message' => 'Step deleted'], 200);
    }
}
