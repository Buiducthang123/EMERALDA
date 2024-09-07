<?php
namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
    protected $authRepo;
    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function login($email, $password)
    {
        $user = $this->authRepo->getUserByUsername($email);
        if (!$user) {
            return response()->json([
                'message' => 'Tên đăng nhập không tồn tại',
            ], 404);
        }

        if (!password_verify($password, $user->password)) {
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

        $user = $this->authRepo->create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng ký thành công',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
