<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

/**
 * @group Authenticating Management
 *
 * APIs for managing brands in the system.
 */



class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

   /**
 * Register a new user (Email & Password)
 *
 * @bodyParam name string required The user's full name. Example: Yassin Ali
 * @bodyParam email string required A valid email address. Example: yassin@example.com
 * @bodyParam password string required A secure password. Example: secret123
 * @bodyParam phone string optional The user's phone number. Example: +967770000000
 *
 * @response 201 {
 *   "status": true,
 *   "message": "User registered successfully!",
 *   "data": {
 *       "id": 1,
 *       "name": "Yassin Ali",
 *       "email": "yassin@example.com"
 *   }
 * }
 */
public function register(RegisterUserRequest $request): JsonResponse
{
    $data = $request->validated();

    // تجاهل أي google_id تم إرساله
    if (isset($data['google_id'])) {
        unset($data['google_id']);
    }

    $data['password'] = Hash::make($data['password']);
    $user = $this->userService->store($data);

    return response()->json([
        'status' => true,
        'message' => 'User registered successfully!',
        'data' => $user
    ], 201);
}


 

    /**
     * Login a user (Email/Password or Google ID)
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
}
