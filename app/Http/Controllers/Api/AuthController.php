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
 * Login a user
 *
 * This endpoint allows a user to login either via Google ID or via email & password.
 *
 * @group Authentication
 *
 * @bodyParam email string optional A valid email address. Required if google_id is not provided. Example: yassin@example.com
 * @bodyParam password string optional A secure password. Required if google_id is not provided. Example: secret123
 * @bodyParam google_id string optional The user's Google ID. Required if email/password are not provided. Example: 1234567890
 *
 * @response 200 {
 *   "success": true,
 *   "message": "Login successful",
 *   "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
 *   "user": {
 *     "id": 13,
 *     "name": "Yassin",
 *     "email": "yassin@example.com",
 *     "phone": "+967770000000",
 *     "google_id": "1234567890"
 *   }
 * }
 *
 * @response 401 {
 *   "success": false,
 *   "message": "Invalid email or password"
 * }
 *
 * @response 422 {
 *   "success": false,
 *   "message": "Email and password are required if google_id is not provided."
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
 * Login user
 *
 * This endpoint allows users to log in using either email/password or Google ID.
 *
 * @group Authentication
 *
 * @bodyParam email string required if no google_id The user's email. Example: yassin@example.com
 * @bodyParam password string required if no google_id The user's password. Example: secret123
 * @bodyParam google_id string required if no email Login with Google ID. Example: 1234567890
 *
 * @response 200 {
 *   "success": true,
 *   "message": "Login successful",
 *   "token": "1|abcde12345tokenexample",
 *   "user": { "id": 1, "name": "Yassin Ali", "email": "yassin@example.com" }
 * }
 * @response 401 {
 *   "success": false,
 *   "message": "Invalid credentials"
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


    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
