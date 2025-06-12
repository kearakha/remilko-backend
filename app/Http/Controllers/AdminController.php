<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recook;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Resources\RecookResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Mail\CreatorInvitationMail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function stats()
    {
        $totalRecipes = Recipe::count();
        $totalRecooks = Recook::count();

        return response()->json([
            'data' => [
                'total_recipes' => $totalRecipes,
                'total_recooks' => $totalRecooks,
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Dashboard summary retrieved successfully',
            ]
        ], 200);
    }

    public function getRecookVerifications(Request $request)
    {
        $status = $request->query('status');
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);
        $query = Recook::with(['user', 'recipe']);

        $validStatuses = ['menunggu', 'diterima', 'ditolak'];
        if ($status && in_array(strtolower($status), $validStatuses)) {
            $query->where('status', strtolower($status));
            Log::info('getRecookVerifications: Filtering by status = ' . $status);
        } else {
            Log::info('getRecookVerifications: No specific or valid status requested. Fetching all recooks.');
        }

        $recooks = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Menggunakan RecookResource::collection untuk memformat koleksi
        $formattedRecooks = RecookResource::collection($recooks->getCollection());

        return response()->json([
            'data' => [
                'recooks' => $formattedRecooks,
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Daftar verifikasi recook berhasil diambil.',
                'pagination' => [
                    'current_page' => $recooks->currentPage(),
                    'last_page' => $recooks->lastPage(),
                    'per_page' => $recooks->perPage(),
                    'total' => $recooks->total(),
                    'from' => $recooks->firstItem(),
                    'to' => $recooks->lastItem(),
                ]
            ]
        ], 200);
    }

    public function approveRecook($id)
    {
        $recook = Recook::findOrFail($id);
        $currentStatus = $recook->status;
        if ($currentStatus === 'diterima') {
            return response()->json([
                'meta' => [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Recook sudah diterima.'
                ]
            ], 400);
        }
        $recook->status = 'diterima';
        $recook->save();

        return response()->json([
            'data' => [
                'recook' => new RecookResource($recook),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recook berhasil disetujui.'
            ]
        ], 200);
    }

    public function rejectRecook($id, Request $request)
    {
        $recook = Recook::findOrFail($id);
        $currentStatus = $recook->status;
        if ($currentStatus === 'ditolak') {
            return response()->json([
                'meta' => [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Recook sudah ditolak.'
                ]
            ], 400);
        }
        $recook->status = 'ditolak';
        $recook->save();

        return response()->json([
            'data' => [
                'recook' => new RecookResource($recook->load(['user', 'recipe']))
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recook ditolak.'
            ]
        ], 200);
    }

    public function getRecommendationStatus(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $query = Recipe::with('user');

        if ($filter === 'recommended') {
            $query->where('is_recommended', true);
        } elseif ($filter === 'not_recommended') {
            $query->where('is_recommended', false);
        }

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $recipes = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return RecipeResource::collection($recipes)->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Recipes fetched successfully',
            ],
        ]);
    }

    public function toggleRecommendation($id)
    {
        // Ambil model resep berdasarkan ID
        $recipe = Recipe::findOrFail($id);

        // Toggle status is_recommended
        $recipe->is_recommended = !$recipe->is_recommended;
        $recipe->save();

        return response()->json([
            'data' => ['recipe' => new RecipeResource($recipe)],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Status rekomendasi berhasil diperbarui menjadi ' . ($recipe->is_recommended ? 'Direkomendasikan' : 'Tidak Direkomendasikan')
            ]
        ]);
    }

    public function indexCreators(Request $request)
    {
        // Mendapatkan status yang diminta dari frontend, defaultnya 'pending'
        $requestedStatus = $request->input('status');
        // $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $query = User::where('role', 'creator');

        if ($requestedStatus !== 'all') { // Jika filter bukan 'all', terapkan filter status
            $dbStatus = null; // Inisialisasi null

            // Mapping status dari frontend (lowercase) ke nilai di DB (sesuai ENUM/string Anda)
            switch (Str::lower($requestedStatus)) {
                case 'pending':
                    $dbStatus = 'Menunggu';
                    break;
                case 'accepted':
                    $dbStatus = 'Diterima';
                    break;
                case 'rejected':
                    $dbStatus = 'Ditolak';
                    break;
                default:
                    Log::warning('[AdminController][CreatorsFilter] Status kreator tidak dikenal atau salah: ' . $requestedStatus);
                    // Jika status tidak valid, jangan terapkan filter.
                    break;
            }

            if ($dbStatus) { // Hanya terapkan where clause jika $dbStatus memiliki nilai yang valid
                $query->where('status', $dbStatus);
                Log::info('[AdminController][CreatorsFilter] Menerapkan filter status DB: ' . $dbStatus);
            } else {
                Log::info('[AdminController][CreatorsFilter] Status input tidak valid, tidak menerapkan filter.');
            }
        } else {
            Log::info('[AdminController][CreatorsFilter] Mengambil semua kreator, tanpa filter status.');
        }

        // // Menerapkan filter pencarian jika ada
        // if ($search) {
        //     $query->where(function ($q) use ($search) {
        //         $q->where('name', 'like', '%' . $search . '%')
        //             ->orWhere('username', 'like', '%' . $search . '%')
        //             ->orWhere('email', 'like', '%' . $search . '%');
        //     });
        // }

        // Mengambil data kreator dengan paginasi
        $creators = $query->paginate($perPage, ['*'], 'page', $page);

        // Mengembalikan respons JSON
        return response()->json([
            'data' => [
                'creators' => UserResource::collection($creators->items()),
            ],
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Daftar kreator berhasil diambil.',
                'pagination' => [
                    'current_page' => $creators->currentPage(),
                    'last_page' => $creators->lastPage(),
                    'per_page' => $creators->perPage(),
                    'total' => $creators->total(),
                    'from' => $creators->firstItem(),
                    'to' => $creators->lastItem(),
                ],
            ]
        ]);
    }

    public function inviteCreator(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'id' => Str::random(8),
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'creator',
                'status' => 'Menunggu',
            ]);

            try {
                Mail::to($user->email)->send(new CreatorInvitationMail(
                    $user->name,
                    $user->username,
                    $validatedData['password']
                ));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email undangan kreator: ' . $e->getMessage());
                // Anda bisa memilih untuk mengembalikan error atau tetap sukses tapi log error email
            }

            return response()->json([
                'data' => [
                    'creator' => new UserResource($user),
                ],
                'meta' => [
                    'code' => 201,
                    'status' => 'success',
                    'message' => 'Akun kreator berhasil dibuat dengan status "Menunggu" dan detail dikirim ke email.',
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'code' => 422,
                    'status' => 'error',
                    'message' => 'Validasi gagal.',
                    'errors' => $e->errors(),
                ]
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error saat mengundang kreator: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'meta' => [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan server saat mengundang kreator.',
                ]
            ], 500);
        }
    }

    public function acceptCreatorInvitation(User $user)
    {
        // Metode ini mungkin tidak lagi digunakan jika penerimaan dilakukan saat login pertama
        // Namun, jika Anda tetap ingin tombol "Terima" di admin dashboard,
        // maka metode ini akan langsung mengubah status kreator yang dipilih
        if ($user->role !== 'creator') {
            return response()->json(['meta' => ['code' => 400, 'status' => 'error', 'message' => 'User bukan kreator.']], 400);
        }
        if ($user->status === 'Diterima') {
            return response()->json(['meta' => ['code' => 200, 'status' => 'success', 'message' => 'Status kreator sudah diterima.']]);
        }
        $user->status = 'Diterima';
        $user->save();
        return response()->json(['meta' => ['code' => 200, 'status' => 'success', 'message' => 'Undangan kreator berhasil diterima.']]);
    }

    public function rejectCreatorInvitation(User $user)
    {
        // Metode ini masih relevan untuk admin menolak undangan secara manual
        if ($user->role !== 'creator') {
            return response()->json(['meta' => ['code' => 400, 'status' => 'error', 'message' => 'User bukan kreator.']], 400);
        }
        if ($user->status === 'Ditolak') {
            return response()->json(['meta' => ['code' => 200, 'status' => 'success', 'message' => 'Status kreator sudah ditolak.']]);
        }
        $user->status = 'Ditolak';
        $user->save();
        return response()->json(['meta' => ['code' => 200, 'status' => 'success', 'message' => 'Undangan kreator berhasil ditolak.']]);
    }
}
