<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
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
            'id' => Str::random(8),
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'photo_user' => $validated['photo_user'],
            'status' => 'Diterima'
        ]);

        return response()->json([
            "data" => [
                'user' => UserResource::collection([$user]),
            ],
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "User registered successfully",
            ],
            200
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            // Mengembalikan respons error standar jika kredensial tidak valid
            return response()->json([
                'meta' => [
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.'
                ]
            ], 401);
        }

        // <<< PERBAIKAN KRITIKAL DI SINI >>>
        // JWTAuth::user() seharusnya sudah mengembalikan objek model User tunggal.
        // Kita tidak perlu lagi melakukan User::where()->get() yang menyebabkan Collection.
        $user = JWTAuth::user();

        // Pastikan $user memang objek User dan bukan null (walaupun jarang terjadi setelah attempt sukses)
        if (!$user instanceof User) {
            // Jika ini terjadi, ada masalah mendalam dengan JWTAuth atau model User Anda.
            Log::error('Login successful but JWTAuth::user() did not return a User model. Type: ' . get_class($user));
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan internal: Gagal mengambil data pengguna.'
                ]
            ], 500);
        }
        // <<< AKHIR PERBAIKAN KRITIKAL >>>


        // Logika untuk mengubah status kreator saat login pertama.
        // Karena $user sekarang pasti objek User, akses properti akan berfungsi.
        if ($user->role === 'creator' && $user->status === 'Menunggu') {
            $user->status = 'Diterima';
            $user->save();
            Log::info("Creator {$user->username} status changed from 'Menunggu' to 'Diterima' upon first login.");
        }

        return response()->json([
            "data" => [
                'user' => new UserResource($user), // Gunakan new UserResource($user) untuk satu objek
            ],
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "User logged in successfully",
            ],
            'token' => $token, // Token langsung di luar 'data' jika Anda ingin seperti ini
        ], 200); // Pastikan status HTTP 200 adalah parameter kedua response()->json()
    }

    public function user()
    {
        $userJWT = JWTAuth::user();
        $user = User::where("id", $userJWT->id)->get();

        return response()->json([
            "data" => [
                'user' => UserResource::collection($user),
            ],
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "User profile retrieved successfully",
            ],
            200
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logout successful']);
    }

    public function updateProfile(Request $request)
    {
        $user = JWTAuth::user();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|required|string|max:255',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
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
            unset($validated['photo_user']); // Remove if no file is uploaded
        }

        $user->update($validated);

        return response()->json([
            "data" => [
                'user' => UserResource::collection([$user]),
            ],
            "meta" => [
                "code" => 200,
                "status" => "success",
                "message" => "User profile updated successfully",
            ],
            200
        ]);
    }
}
