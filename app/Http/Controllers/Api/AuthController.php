<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display all users (for testing only)
     */
    public function index()
    {
      
    }

/**
 * Register a new user
 *
 * This endpoint allows you to register a new user with basic details.
 *
 * @group Authentication
 *
 * @bodyParam name string required The user's full name. Example: Yassin Ali
 * @bodyParam email string required A valid email address. Example: yassin@example.com
 * @bodyParam password string required A secure password. Example: secret123
 * @bodyParam google_id string optional The user's Google ID. Example: 1234567890
 * @bodyParam phone string optional The user's phone number. Example: +967770000000
 *
 * @response 201 {
 *   "success": true,
 *   "message": "User registered successfully",
 *   "data": {
 *     "id": 1,
 *     "name": "Yassin Ali",
 *     "email": "yassin@example.com"
 *   }
 * }
 */
    public function store(RegisterUserRequest $request)
    {
        $data = $request->validated();

        // ✅ إذا المستخدم يسجل عبر Google ID
        if (isset($data['google_id'])) {
            $user = User::where('google_id', $data['google_id'])->first();

            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'User already registered via Google!',
                    'data' => $user
                ], 200);
            }

            $user = $this->userService->store($data);

            return response()->json([
                'status' => true,
                'message' => 'User registered via Google successfully!',
                'data' => $user
            ], 200);
        }

        // ✅ التسجيل العادي
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = $this->userService->store($data);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully!',
            'data' => $user
        ], 200);
    }


/**
 * Login a user
 *
 * This endpoint allows a user to login via email/password or Google ID.
 *
 * @group Authentication
 *
 * @bodyParam email string optional The user's email. Required if google_id not provided. Example: yassin@example.com
 * @bodyParam password string optional The user's password. Required if google_id not provided. Example: secret123
 * @bodyParam google_id string optional The user's Google ID. Example: 1234567890
 *
 * @response 200 {
 *   "success": true,
 *   "message": "Login successful",
 *   "token": "2|hhi7xBRhqLkotdw8PuNZO1oxxZ49N4u8AqhNyw171b208e72",
 *   "user": {
 *       "id": 1,
 *       "name": "Yassin Ali",
 *       "email": "yassin@example.com"
 *   }
 * }
 */
   public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'password' => 'nullable|string',
            'google_id' => 'nullable|string',
        ]);

        $result = $this->userService->login($validated);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'token' => $result['token'] ?? null,
            'user' => $result['user'] ?? null,
        ], $result['status']);
    }

    /**
     * Get user by ID
     *
     * This endpoint retrieves detailed information about a specific user by their ID.
     *
     * @group Users
     *
     * @urlParam id integer required The ID of the user. Example: 5
     *
     * @response 200 {
     *   "success": true,
     *   "message": "User retrieved successfully",
     *   "user": {
     *     "id": 5,
     *     "name": "Yassin Ali",
     *     "email": "yassin@example.com",
     *     "phone": "+967770000000",
     *     "created_at": "2025-10-13T12:45:00.000000Z",
     *     "updated_at": "2025-10-13T12:45:00.000000Z"
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "User not found"
     * }
     */
   public function show($id): JsonResponse
    {
        $result = $this->userService->findUser($id);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'] ?? null,
            'user' => $result['user'] ?? null,
        ], $result['status']);
    }
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
