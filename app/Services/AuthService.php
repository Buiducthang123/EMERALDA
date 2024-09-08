<?php
namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $authRepo;
    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function login($email, $password)
    {
        $user = $this->authRepo->getUserByEmail($email);
        if (!$user) {
            return response()->json([
                'message' => 'Tên đăng nhập không tồn tại',
            ], 404);
        }
        $credential = Auth::attempt(['email' => $email, 'password' => $password]);
        if (!$credential) {
            return response()->json([
                'message' => 'Mật khẩu không chính xác',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function register($data)
    {
        $data['password'] = bcrypt($data['password']);

        $user = $this->authRepo->getUserByEmail($data['email']);

        if ($user) {
            return response()->json([
                'message' => 'Email đã tồn tại',
            ], 400);
        }

        $user = $this->authRepo->create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng ký thành công',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
