<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Comment;
use App\Http\Resources\RecipeDetailResource;

class RecipeController extends Controller
{
    //halaman utama - list recipe
    public function index()
    {
        $recipes = Recipe::with(['user'])->latest()->paginate(8);

        return response()->json([
            'data' => [
                'recipes' => RecipeResource::collection($recipes),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List of recipes',
                'pagination' => [
                    'total' => $recipes->total(),
                    'count' => $recipes->count(),
                    'per_page' => $recipes->perPage(),
                    'current_page' => $recipes->currentPage(),
                    'total_pages' => $recipes->lastPage(),
                ],
            ],
        ]);
    }

    //buat recipe
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'price_estimate' => 'nullable|integer',
            'cook_time' => 'nullable|integer',
            'portion_size' => 'nullable|string',
            'category' => 'nullable|in:Sarapan, Makan Siang, Makan Malam, Salad, Snack',
            'Hemat',
            'label' => 'nullable|in:Tanpa Babi,Halal,Vegetarian,Vegan,Gluten-Free,None',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/recipe'), $filename);
            $validated['photo'] = $filename;
        }

        $recipe = Recipe::create([
            'id' => Str::random(8),
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
        ]);

        return response()->json([
            "data" => [
                "recipe" => RecipeResource::collection($recipe),
            ],
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "List of recipes",
            ],
            200
        ], 201);
    }

    //show - recipe detail
    public function show($id)
    {
        $recipe = Recipe::with([
            'user',
            'recipeIngredient',
            'recipeStep',
            'recipeTool',
            'recipeNutrition',
            'comment.user',
            'recook.user',
        ])->findOrFail($id);

        return response()->json([
            'data' => [
                'recipe' => new RecipeDetailResource($recipe),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recipe details fetched successfully',
            ],
            200
        ]);
    }

    //update
    public function update(Request $request, $id)
    {
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
            'category' => 'nullable|in:Sarapan, Makan Siang, Makan Malam, Salad, Snack,Hemat',
            'label' => 'sometimes|nullable|in:Tanpa Babi,Halal,Vegetarian,Vegan,Gluten-Free,None',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'sometimes|nullable|url',
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
            $file->move(public_path('images/recipe'), $filename);
            $validated['photo'] = $filename;
        }

        $recipe->update($validated);

        return response()->json([
            "data" => [
                "recipe" => RecipeResource::collection($recipe),
            ],
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "List of recipes",
            ],
            200
        ]);
    }

    //hapus
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
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "List of recipes",
            ],
            200
        ]);
    }

    // filter dari category
    public function filter(Request $request)
    {
        $query = Recipe::with(['recipeIngredient', 'user']);

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('recipeIngredient')) {
            $query->whereHas('recipeIngredient', function ($q) use ($request) {
                $q->where('ingredient_name', 'LIKE', '%' . $request->ingredient . '%');
            });
        }

        $recipes = $query->paginate(8);

        return response()->json([
            'data' => [
                'recipes' => RecipeResource::collection($recipes),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Filtered recipes',
                'pagination' => [
                    'current_page' => $recipes->currentPage(),
                    'last_page' => $recipes->lastPage(),
                    'total' => $recipes->total(),
                ]
            ]
        ]);
    }
}
