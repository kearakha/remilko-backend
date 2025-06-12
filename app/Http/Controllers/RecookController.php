<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecookResource;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\Recook;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecookController extends Controller
{
    public function index()
    {
        $user = JWTAuth::user();
        $recooks = Recook::with('recipe')->where('user_id', $user->id)->get();

        return response()->json([
            'data' => [
                'recooks' => RecookResource::collection($recooks),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'List of recooks',
            ],
            200
        ]);
    }

    public function show($recipe_id, $id)
    {
        $recook = Recook::where('recipe_id', $recipe_id)->findOrFail($id);

        if (!$recook) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Recook not found',
            ], 404);
        }
        return response()->json([
            'data' => [
                'recook' => new RecookResource($recook),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recook details retrieved successfully',
            ],
            200
        ]);
    }

    public function store(Request $request, $recipe_id)
    {
        $user = JWTAuth::user();

        $validator = Validator::make($request->all(), [
            'photo_recook' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'difficulty' => 'required|in:Mudah,Sedang,Sulit',
            'taste' => 'required|in:Enak,Biasa,Tidak Enak',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo_recook')) {
            $file = $request->file('photo_recook');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/recook'), $filename);
            $validated['photo_recook'] = $filename;
        }

        $recook = Recook::create([
            'id' => Str::random(8),
            'user_id' => $user->id,
            'recipe_id' => $recipe_id,
            'photo_recook' => $validated['photo_recook'],
            'difficulty' => $validated['difficulty'],
            'taste' => $validated['taste'],
            'description' => $validated['description'],
            'status' => 'Menunggu',
        ]);

        return response()->json([
            'data' => [
                'recook' => new RecookResource($recook),
            ],
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Recook created successfully',
            ]
        ], 201);
    }

    public function update(Request $request, $recipe_id, $id)
    {
        $recook = Recook::where('recipe_id', $recipe_id)->findOrFail($id);

        if (!$recook) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Recook not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'photo_recook' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'difficulty' => 'in:Mudah,Sedang,Sulit',
            'taste' => 'in:Enak,Biasa,Tidak Enak',
            'description' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo_recook')) {
            $file = $request->file('photo_recook');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/recook'), $filename);
            $recook->photo_recook = $filename;
        }

        $recook->update($validated);

        return response()->json([
            'data' => [
                'recook' => new RecookResource($recook),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recook updated successfully',
            ],
            200
        ]);
    }

    public function destroy($recipe_id, $id)
    {
        $recook = Recook::where('recipe_id', $recipe_id)->findOrFail($id);

        if (!$recook) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Recook not found',
            ], 404);
        }

        $recook->delete();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recook deleted successfully',
            ],
            200
        ]);
    }
}
