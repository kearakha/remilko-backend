<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipe = Recipe::all();
        return response()->json([
            'user' => JWTAuth::user(),
            $recipe,
            200
        ]);
    }

    public function store(Request $request)
    {
        if (!in_array(JWTAuth::user()->role, ['admin', 'content_creator'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'price_estimate' => 'nullable|integer',
            'cook_time' => 'nullable|integer',
            'portion_size' => 'nullable|string',
            'category' => 'nullable|in:Hemat,Tanpa Kompor,Cepat Saji',
            'label' => 'nullable|in:Tanpa Babi,Halal,Vegetarian,Vegan,Gluten-Free,None',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'nullable|url',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['photo'] = $filename;
        }

        $recipe = Recipe::create([
            'user_id' => Auth::user()->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'rating' => $validated['rating'],
            'price_estimate' => $validated['price_estimate'],
            'cook_time' => $validated['cook_time'],
            'portion_size' => $validated['portion_size'],
            'category' => $validated['category'],
            'label' => $validated['label'],
            'photo' => $validated['photo'],
            'url_video' => $validated['url_video'],
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'message' => 'Recipe created',
            'recipe' => $recipe
        ], 201);
    }

    public function show($id)
    {
        if (!in_array(JWTAuth::user()->role, ['admin', 'user'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recipe = Recipe::with('recipeStep')->find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }

        return response()->json($recipe);
    }

    public function update(Request $request, $id)
    {
        if (!in_array(JWTAuth::user()->role, ['admin', 'content_creator'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recipe not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'rating' => 'sometimes|nullable|numeric|min:0|max:5',
            'price_estimate' => 'sometimes|nullable|integer',
            'cook_time' => 'sometimes|nullable|integer',
            'portion_size' => 'sometimes|nullable|string',
            'category' => 'sometimes|nullable|in:Hemat,Tanpa Kompor,Cepat Saji',
            'label' => 'sometimes|nullable|in:Tanpa Babi,Halal,Vegetarian,Vegan,Gluten-Free,None',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'sometimes|nullable|url',
            'comment' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['photo'] = $filename;
        }

        // dd($validated);

        $recipe->update($validated);

        // dd($recipe);

        return response()->json([
            'status' => 'success',
            'data' => $recipe
        ]);
    }

    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recipe not found'
            ], 404);
        }

        $recipe->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recipe deleted successfully'
        ]);
    }
}
