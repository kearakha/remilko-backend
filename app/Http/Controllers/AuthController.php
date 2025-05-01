<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'photo_user' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('photo_user')) {
            $file = $request->file('photo_user');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile/user'), $filename);
            $validated['photo_user'] = $filename;
        } else {
            $validated['photo_user'] = null; // Set default value if no file is uploaded
        }

        $user = User::create([
            'id' => Str::uuid()->toString(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'photo_user' => $validated['photo_user'],
        ]);

        return response()->json([
            'user' => $user,
            // 'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = JWTAuth::user();

        return response()->json([
            'status' => 'Success',
            'message' => 'Login Success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
        ]);
    }

    public function user()
    {
        return response()->json(JWTAuth::user());
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logout successful']);
    }

    public function updateProfile(Request $request)
    {
        $user = JWTAuth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:6',
            'photo_user' => 'sometimes|nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        if (isset($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo_user')) {
            $file = $request->file('photo_user');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile/user'), $filename);
            $user->photo_user = $filename;
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }
}
