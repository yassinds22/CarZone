<?php   

namespace App\Services;

use App\Repository\UserRepository;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as FacadesLog;

class UserService{
    public $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository=$userRepository;

    }



        public function find($id){}
    public function store(array $data){
        return $this->userRepository->Storeuser($data);

    }

     public function login(array $credentials): array
    {
        try {
            // Google OAuth login
            if (!empty($credentials['google_id'])) {
                $user = $this->userRepository->findByGoogleId($credentials['google_id']);

                if (!$user) {
                    return [
                        'success' => false,
                        'message' => 'No account linked with this Google ID.',
                        'status' => 401
                    ];
                }

                $token = $user->createToken('auth_token')->plainTextToken;

                return [
                    'success' => true,
                    'message' => 'Login via Google successful',
                    'token' => $token,
                    'user' => $user,
                    'status' => 200
                ];
            }

            // Email/Password login
            if (empty($credentials['email']) || empty($credentials['password'])) {
                return [
                    'success' => false,
                    'message' => 'Email and password are required if google_id is not provided.',
                    'status' => 422
                ];
            }

            $user = $this->userRepository->findByEmail($credentials['email']);

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return [
                    'success' => false,
                    'message' => 'Invalid email or password',
                    'status' => 401
                ];
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
                'status' => 200
            ];

        } catch (\Exception $e) {
            FacadesLog::error('Login error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Authentication service unavailable',
                'status' => 503
            ];
        }
    }
    public function update($id, array $data){}
    public function delete($id){}
    public function findByEmail($email){}
}