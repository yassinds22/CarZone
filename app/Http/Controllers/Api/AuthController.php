<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\UserService;
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
     * عرض كل المستخدمين (للتجربة فقط)
     */
    public function index()
    {
        $data = User::all();
        return response()->json($data);
    }

    /**
     * التسجيل العادي أو عبر google_id
     */
    public function store(RegisterUserRequest $request)
    {
        $data = $request->validated();

        // ✅ إذا المستخدم يسجل عبر Google ID
        if (isset($data['google_id'])) {
            $user = User::where('google_id', $data['google_id'])->first();

            if ($user) {
                // المستخدم موجود مسبقًا
                return response()->json([
                    'status' => true,
                    'message' => 'User already registered via Google!',
                    'data' => $user
                ], 200);
            }

            // إنشاء مستخدم جديد عبر Google ID
            $user = $this->userService->store($data);

            return response()->json([
                'status' => true,
                'message' => 'User registered via Google successfully!',
                'data' => $user
            ], 200);
        }

        // ✅ التسجيل العادي (email/password)
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

    // باقي الدوال غير ضرورية الآن
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
