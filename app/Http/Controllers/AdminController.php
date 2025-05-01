<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Recook;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard Ringkasan
    public function index()
    {
        $totalRecipes = Recipe::count();
        $totalRecooks = Recook::count();
        $pendingRecooks = Recook::where('status', 'Menunggu')->count();
        $invitedCreators = User::where('role', 'creator')->get();

        return response()->json([
            'total_recipes' => $totalRecipes,
            'total_recooks' => $totalRecooks,
            'pending_recooks' => $pendingRecooks,
            'creators' => $invitedCreators
        ]);
    }

    // Verifikasi Recook
    public function approveRecook($id)
    {
        $recook = Recook::findOrFail($id);
        $recook->status = 'Diterima';
        $recook = $recook->save();

        return response()->json(['message' => 'Recook approved']);
    }

    public function rejectRecook($id)
    {
        $recook = Recook::findOrFail($id);
        $recook->status = 'Ditolak';
        $recook->save();

        return response()->json(['message' => 'Recook rejected']);
    }

    public function recentActivities()
    {
        $recent_recooks = Recook::with('user', 'recipe')->latest()->take(10)->get();

        return response()->json([
            'recent_recooks' => $recent_recooks,
        ]);
    }

    public function toogleRecommendation($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->is_recommended = !$recipe->is_recommended;
        $recipe->save();

        return response()->json([
            'message' => 'Recipe recommendation status updated',
            'recipe' => $recipe,
        ]);
    }

    // Kelola Konten Kreator
    public function inviteCreator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $photoname = null;
        if ($request->hasFile('photo_user')) {
            $file = $request->file('photo_user');
            $photoname = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile/creator'), $photoname);
            $validated['photo_user'] = $photoname;
        }

        $creator = User::where('email', $request->email)->first();

        if (!$creator) {
            $creator = User::create([
                'email' => $request->email,
                'name' => 'Content Creator',
                'password' => Hash::make('password123'),
                'role' => 'creator',
                'photo_user' => $photoname,
            ]);
        }

        return response()->json(['message' => 'Kreator berhasil diundang', 'user' => $creator]);
    }

    public function deleteCreator($id)
    {
        $creator = User::findOrFail($id);
        $creator->delete();

        return response()->json(['message' => 'Kreator berhasil dihapus']);
    }
}
