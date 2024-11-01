<?php
namespace App\Services;

use App\Enums\AccountStatus;
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

        if($user->status == AccountStatus::BLOCKED) {
            return response()->json([
                'message' => 'Tài khoản đã bị khóa',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response([
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
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
