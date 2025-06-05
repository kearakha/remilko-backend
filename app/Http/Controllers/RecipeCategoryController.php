<?php

namespace App\Http\Controllers;

use App\Models\RecipeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecipeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($recipe_id)
    {
        $recipe = RecipeCategory::findOrFail($recipe_id);
        $categories = RecipeCategory::where('recipe_id', $recipe->id)->get();

        if ($categories->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No recipe categories found'
            ], 404);
        }

        return response()->json([
            'data' => [
                'categories' => $categories,
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List of recipe categories',
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $recipe_id)
    {
        $recipe = RecipeCategory::findOrFail($recipe_id);

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'photo_category' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo_category')) {
            $file = $request->file('photo_category');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/recipe/category'), $filename);
            $validated['photo_category'] = $filename;
        } else {
            $validated['photo_category'] = null; // Set to null if no file is uploaded
        }

        $category = RecipeCategory::create([
            'id' => Str::uuid(),
            'recipe_id' => $recipe->id,
            'category_name' => $validated['category_name'],
            'photo_category' => $validated['photo_category'],
        ]);

        return response()->json([
            'data' => [
                'category' => $category,
            ],
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Recipe category created successfully',
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($recipe_id, $id)
    {
        $category = RecipeCategory::where('recipe_id', $recipe_id)->findOrFail($id);

        return response()->json([
            'data' => [
                'category' => $category,
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recipe category retrieved successfully',
            ],
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $recipe_id, $id)
    {
        $category = RecipeCategory::where('recipe_id', $recipe_id)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_name' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $category->update($validated);

        return response()->json([
            'data' => [
                'category' => $category,
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recipe category updated successfully',
            ],
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($recipe_id, $id)
    {
        $category = RecipeCategory::where('recipe_id', $recipe_id)->findOrFail($id);
        $category->delete();

        return response()->json([
            'data' => [
                'message' => 'Recipe category deleted successfully',
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recipe category deleted successfully',
            ],
        ], 200);
    }
}
