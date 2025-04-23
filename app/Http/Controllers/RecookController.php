<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\Recook;
use Illuminate\Support\Facades\Validator;

class RecookController extends Controller
{
    public function index()
    {
        $user = JWTAuth::user();
        $recooks = Recook::with('recipe')->where('user_id', $user->id)->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Recooks retrieved successfully',
            'recooks' => $recooks,
        ]);
    }

    public function show($id)
    {
        $recook = Recook::with('recipe')->findOrFail($id);

        if (!$recook) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Recook not found',
            ], 404);
        }
        return response()->json([
            'status' => 'Success',
            'message' => 'Recook retrieved successfully',
            'recook' => $recook,
        ]);
    }

    public function store(Request $request)
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
            $file->move(public_path('images'), $filename);
            $validated['photo_recook'] = $filename;
        }

        $recook = Recook::create([
            'user_id' => $user->id,
            'recipe_id' => $request->input('recipe_id'),
            'photo_recook' => $validated['photo_recook'],
            'difficulty' => $validated['difficulty'],
            'taste' => $validated['taste'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Recook created successfully',
            'recook' => $recook,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $recook = Recook::findOrFail($id);

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
            $file->move(public_path('images'), $filename);
            $recook->photo_recook = $filename;
        }

        $recook->update($validated);

        return response()->json([
            'status' => 'Success',
            'message' => 'Recook updated successfully',
            'recook' => $recook,
        ]);
    }

    public function destroy($id)
    {
        $recook = Recook::findOrFail($id);

        if (!$recook) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Recook not found',
            ], 404);
        }

        $recook->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Recook deleted successfully',
        ]);
    }
}
